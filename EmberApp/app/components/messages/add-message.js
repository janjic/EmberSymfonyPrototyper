import Ember from 'ember';
const { ApiCode, Translator } = window;
import LoadingStateMixin from '../../mixins/loading-state';
import { task, timeout } from 'ember-concurrency';
import Changeset from 'ember-changeset';
import lookupValidator from './../../utils/lookupValidator';
import MessageValidations from './../../validations/message-new';

export default Ember.Component.extend(LoadingStateMixin, {
    MessageValidations,
    currentUser: Ember.inject.service('current-user'),
    fileTemp: null,

    search: task(function * (text, page, perPage) {
        yield timeout(200);
        let result = this.get('searchQuery')(page, text, perPage);
        let agentId = this.get('currentUser.user.id');

        return result.then((agents)=>{
            return agents.filter( agent => agent.get('id') !== agentId );
        });
    }),

    init() {
        this._super(...arguments);
        this.changeset = new Changeset(this.get('model'), lookupValidator(MessageValidations), MessageValidations);
    },

    actions: {
        sendMessage() {
            this.set('model.isDraft', false);
            this.send('processSave');
        },

        saveAsDraft() {
            this.set('model.isDraft', true);
            this.send('processSave');
        },

        processSave() {
            if (this.get('changeset').validate() && this.get('changeset').get('isValid')) {
                this.showLoader();
                let message = this.get('model');
                let shouldTransition = !message.get('isDraft');
                if (this.get('fileTemp')) {
                    let fileObj = this.get('createFileAction')(this.get('fileTemp'));
                    message.set('file', fileObj);
                }
                message.set('sender', this.get('currentUser.user'));
                message.save().then(() => {
                    this.toast.success('models.message.save');
                    this.disableLoader();
                    if(shouldTransition) {
                        this.get('transitionToInbox')();
                    }
                }, (response) => {
                    this.processErrors(response.errors);
                    this.disableLoader();
                });
            }
        },

        agentSelected(agent){
            this.set('changeset.participants', agent ? [agent] : null);
            this.get('changeset').validate('sender');
        },

        /** validations */
        reset(changeset) {
            return changeset.rollback();
        },

        validateProperty(changeset, property) {
            return changeset.validate(property);
        },

        addedFile (file) {
            let reader = new FileReader();
            this.set('fileTemp', {name: file.name});
            reader.onloadend = () => {
                this.set('fileTemp.base64Content', reader.result);
            };
            reader.readAsDataURL(file);
        },
        removedFile() {
            this.set('fileTemp', null);
        }
    },

    processErrors(errors) {
        errors.forEach((item) => {
            switch (item.status) {
                case ApiCode.ERROR_MESSAGE:
                    this.toast.success(Translator.trans('models.server-error'));
                    break;
                case ApiCode.MESSAGES_UNSUPPORTED_FORMAT:
                    this.toast.success(Translator.trans('models.message.unsupported.file.type'));
                    break;
                default:
                    return;
            }
        });
    },
});