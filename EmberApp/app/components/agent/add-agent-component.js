import Ember from 'ember';
import AddAgentValidations from '../../validations/add-new-agent';
import EditAgentValidations from '../../validations/edit-agent';
import AddressValidations from '../../validations/address';
import {withoutProxies} from './../../utils/proxy-helpers';
import Changeset from 'ember-changeset';
import lookupValidator from './../../utils/lookupValidator';
const {ApiCode, Translator} = window;
import { task, timeout } from 'ember-concurrency';
import LoadingStateMixin from '../../mixins/loading-state';

export default Ember.Component.extend(LoadingStateMixin,{
    items: [],
    selectedTags: [],
    dateInputValid: true,
    isModalOpen:    false,
    currentUser: Ember.inject.service('current-user'),
    isEdit : Ember.computed ('model', function () {
        return this.get('model.id');
    }),
    titles: Ember.computed(function () {
       return ['MR', 'MRS'];
    }),

    isUserAdmin: Ember.computed('currentUser.user', function() {
        return this.get('currentUser.user').get('roles').includes('ROLE_SUPER_ADMIN');
    }),

    init() {
        this._super(...arguments);
        this._setUpComponent();

    },

    _setUpComponent() {
        if (!this.get('model')) {
            this.set('isProfileView', true);
            this.set('model', this.get('currentUser.user'));
        }
        if (this.get('isEdit')) {
            this.set('initialGroup', this.get('model.group'));
            this.set('model.emailRepeat', this.get('model.email'));
            this.changeset = new Changeset(this.get('model'), lookupValidator(EditAgentValidations), EditAgentValidations);
            if( this.get('model.notifications')[0] ){
                this.set('notifications', this.get('model.notifications'));
            } else {
                this.set('notifications', []);
            }
        } else {
            this.changeset = new Changeset(this.get('model'), lookupValidator(AddAgentValidations), AddAgentValidations);
        }
        this.addressChangeset = new Changeset(this.get('changeset.address'), lookupValidator(AddressValidations), AddressValidations);
    },
    image: Ember.Object.create({
        base64Content: null,
        name: null,
    }),
    currentImage: null,

    search: task(function * (text, page, perPage) {
        yield timeout(200);
        return this.get('searchQuery')(page, text, perPage);
    }),

    getImage() {
        if (this.get('changeset.image') && this.get('changeset.image.id')) {
            return this.get('changeset.image');
        }

        return this.get('image');
    },

    processResponse(promise) {
        promise.then(() => {
            this.setLoadingText('loading.redirecting');
            this.disableLoader();
            if (!this.get('isProfileView')) {
                this.toast.success(Translator.trans('models.agent.save.message'));
                this.get('model').reload();
                if (!this.get('isEdit')) {
                    if( this.get('isUserAdmin')) {
                        this.get('goToRoute')('dashboard.agents.all-agents');
                    } else {
                        this.get('goToRoute')('dashboard.agent.agents.all-agents');
                    }
                }
            } else {
                this.get('model').reload();
                this.toast.success(Translator.trans('models.agent.updated.profile'));
            }



        }, (response) => {
            response.errors.forEach((error)=>{
                switch (parseInt(error.status)) {
                    case ApiCode.AGENT_ALREADY_EXIST:
                        this.toast.error(Translator.trans('models.agent.unique.entity'));
                        break;
                    case ApiCode.FILE_SAVING_ERROR:
                        this.toast.error(Translator.trans('models.agent.file.error'));
                        break;
                    case ApiCode.AGENT_SYNC_ERROR:
                        this.toast.error(Translator.trans('models.agent.sync.error'));
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
        updateAgentBirthDate(date){
            this.set('changeset.birthDate', date);
            this.get('changeset').validate('birthDate');
        },

        statusChanged(status) {
            this.set('changeset.enabled', status);
        },
        addedFile (file) {
                if (!file.url) {
                    let image = this.getImage();
                    image.set('webPath', null);
                    image.set('name', file.name);
                    let reader = new FileReader();
                    reader.onloadend = function () {
                        let imgBase64 = reader.result;
                        image.set('base64Content', imgBase64);
                    };
                    reader.readAsDataURL(file);
                }

        },

        removedFile() {
            let img = this.getImage();
            img.set('name', null);
            img.set('webPath', null);
            img.set('base64Content', null);
        },

        saveAgent() {
            if( this.shouldOpenModal(this.get('changeset.group')) && !this.get('changeset.newSuperiorId') ){
                this.set('isModalOpen', true);
                return;
            }

            this.set('changeset.notifications', this.get('notifications'));
            // console.log(this.get('changeset.notifications'));return;
            let changeSet = this.get('changeset');
            let addressChangeSet = this.get('addressChangeset');
            let validation = (changeSet.validate() && addressChangeSet.validate());
            if (validation && changeSet.get('isValid') && addressChangeSet.get('isValid') ) {
                let img = this.getImage();
                //WE can send image to server
                if (!img.get('id') && ((img.get('base64Content')))) {
                    this.get('addImage')(changeSet,img);
                } else if (img.get('id') && !img.get('name') && !img.get('webPath') && !img.get('base64Content')) {
                    img = withoutProxies(img);
                    img.deleteRecord();
                    changeSet.set('image', null);
                }
                this.showLoader('loading.sending.data');
                this.processResponse(changeSet.save());
            }
        },
        roleSelected(group){
            this.set('changeset.newSuperiorId', undefined);
            this.set('isModalOpen', this.shouldOpenModal(group));
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

    shouldOpenModal(group){
        let iniGroup = this.get('initialGroup');
        return iniGroup ? (iniGroup.get('name') !== 'Referee' && group.get('name') === 'Referee' ): false;
    }

});
