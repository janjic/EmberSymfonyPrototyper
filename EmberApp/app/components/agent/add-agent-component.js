import Ember from 'ember';
import AgentValidations from '../../validations/add-new-agent';
import AddressValidations from '../../validations/address';
import Changeset from 'ember-changeset';
import lookupValidator from './../../utils/lookupValidator';
const {ApiCode, Translator} = window;
import LoadingStateMixin from '../../mixins/loading-state';

export default Ember.Component.extend(LoadingStateMixin,{
    AgentValidations,
    AddressValidations,
    dateInputValid: true,
    init() {
        this._super(...arguments);
        this.changeset = new Changeset(this.get('model'), lookupValidator(AgentValidations), AgentValidations);
        this.addressChangeset = new Changeset(this.get('model.address'), lookupValidator(AddressValidations), AddressValidations);
    },
    image: Ember.Object.create({
        base64Content: null,
        name: null,
    }),
    actions: {
        updateAgentBirthDate(date){
            this.set('changeset.birthDate', date);
            this.get('changeset').validate('birthDate');
            let agent = this.model;
            agent.set('birthDate', date);
        },
        addedFile (file) {
            this.set('image.name', file.name);
            let reader = new FileReader();
            let $this = this;
            reader.onloadend = function () {
                let imgBase64 = reader.result;
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
            let isValidated      =  changeSet.validate() && addressChangeSet.validate();
            let isValid          = isValidated && changeSet.get('isValid') && addressChangeSet.get('isValid');
            if (isValid ) {
                agent.set('address', this.get('addressChangeset._content'));
                let img = this.get('image');
                if (img.get('base64Content')) {
                    this.get('addImage')(img);
                }
                this.showLoader('loading.sending.data');
                agent.save().then(() => {
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
            }
        },
        roleSelected(group){
            this.model.set('group', group);
        },
        agentSelected(agent){
            this.model.set('superior', agent);
        },
        titleChanged(title){
            this.set('changeset.title', title);
            this.get('changeset').validate('title');
            this.model.set('title', title);
        },
        updateLanguage(lang){
            this.set('changeset.nationality', lang);
            this.get('changeset').validate('nationality');
            this.set('model.nationality', lang);
        },
        changeCountry(country){
            this.set('addressChangeset.country', country);
            this.get('addressChangeset').validate('country');
            this.set('model.address.country', country);
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
