import Ember from 'ember';
import AgentValidations from '../../validations/add-new-agent';
import AddressValidations from '../../validations/address';
import Changeset from 'ember-changeset';
import lookupValidator from './../../utils/lookupValidator';
const {ApiCode, Translator} = window;
import { task, timeout } from 'ember-concurrency';
import LoadingStateMixin from '../../mixins/loading-state';

export default Ember.Component.extend(LoadingStateMixin,{
    AgentValidations,
    AddressValidations,
    items: [],
    selectedTags: [],
    dateInputValid: true,
    isEdit : Ember.computed ('changeset', function () {
        return this.get('changeset.id');
    }),
    titles: Ember.computed(function () {
       return ['MR', 'MRS'];
    }),

    init() {
        this._super(...arguments);
        this._setUpEditing();
        this.changeset = new Changeset(this.get('model'), lookupValidator(AgentValidations), AgentValidations);
        this.addressChangeset = new Changeset(this.get('changeset.address'), lookupValidator(AddressValidations), AddressValidations);


    },

    _setUpEditing() {
        if (this.get('isEdit')) {
            Ember.defineProperty(this.get('model'), 'emailRepeat', this.get('model.email'));
        }
    },

    currentImage: null,

    image: Ember.Object.create({
        base64Content: null,
        name: null,
    }),

    search: task(function * (text, page, perPage) {
        yield timeout(200);
        return this.get('searchQuery')(page, text, perPage);
    }),

    processResponse(promise) {
        promise.then(() => {
            this.toast.success(Translator.trans('models.agent.save.message'));
            this.setLoadingText('loading.redirecting');
            this.get('goToRoute')('dashboard.agents.all-agents');

        }, (response) => {
            response.errors.forEach((error)=>{
                switch (parseInt(error.status)) {
                    case ApiCode.AGENT_ALREADY_EXIST:
                        this.toast.error(Translator.trans('models.agent.unique.entity'));
                        break;
                    case ApiCode.FILE_SAVING_ERROR:
                        this.toast.error(Translator.trans('models.agent.file.error'));
                        break;
                    case ApiCode.ERROR_MESSAGE:
                        this.toast.error(error.message);
                        break;
                    default:
                        return;
                }
                this.disableLoader();
            });
        });
    },
    actions: {
        addNew(text) {

            let newTag = {
                id: 1,
                email: text
            };
            this.get('items').addObject(newTag);
            this.get('selectedTags').addObject(newTag);
        },

        updateAgentBirthDate(date){
            this.set('changeset.birthDate', date);
            this.get('changeset').validate('birthDate');
        },
        addedFile (file) {
            this.set('image.name', file.name);
            let reader = new FileReader();
            let $this = this;
            reader.onloadend = function () {
                let imgBase64 = reader.result;
                console.log(imgBase64);
                $this.set('image.base64Content', imgBase64);
            };
            reader.readAsDataURL(file);
        },

        removedFile() {
            this.set('image.name', null);
            this.set('image.base64Content', null);
        },

        saveAgent() {
            let agent = this.get('model');
            let changeSet = this.get('changeset');
            let addressChangeSet = this.get('addressChangeset');
            let validation = (changeSet.validate() && addressChangeSet.validate());
            console.log(changeSet.get('isValid'));
            console.log(changeSet.get('errors'));
            if (validation && changeSet.get('isValid') && addressChangeSet.get('isValid') ) {
                let img = this.get('image');
                if (img.get('base64Content')) {
                    this.get('addImage')(img);
                }
                this.showLoader('loading.sending.data');
                this.processResponse(agent.save());
            }
        },
        roleSelected(group){
            this.set('changeset.group', group);
        },

        agentSelected(agent){
            this.set('changeset.superior', agent);
            this.get('changeset').validate('superior');
        },

        titleChanged(title){
            this.set('changeset.title', title);
            this.get('changeset').validate('title');
        },

        updateLanguage(lang){
            this.set('changeset.nationality', lang);
            this.get('changeset').validate('nationality');
        },
        changeCountry(country){
            this.set('addressChangeset.country', country);
            this.get('addressChangeset').validate('country');
        },
        /** validations */
        reset(changeset) {
            return changeset.rollback();
        },
        validateProperty(changeset, property) {
            return changeset.validate(property);
        },
    },

    validateDateInput(date) {
        return (date < (new Date()).setYear((new Date().getFullYear()-18)));
    },

    isObject(val) {
        if (val === null) { return false;}
        return ( (typeof val === 'function') || (typeof val === 'object') );
    },

});
