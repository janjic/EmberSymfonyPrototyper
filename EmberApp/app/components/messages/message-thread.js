import Ember from 'ember';
import LoadingStateMixin from '../../mixins/loading-state';

const { ApiCode, Translator } = window;

export default Ember.Component.extend(LoadingStateMixin, {
    messageBody: '',
    sendBtnDisabled: Ember.computed('messageBody', function () {
        return !(this.get('messageBody'));
    }),
    hideAttachDropzone: true,
    messageBodyChange: Ember.observer('messageBody', function () {
        this.set('hideAttachDropzone', true);
    }),

    currentUser: Ember.inject.service('current-user'),
    fileTemp: null,

    actions:{
        sendMessage() {
            let message = this.get('createMessageAction')({
                body: this.get('messageBody'),
                sender: this.get('currentUser.user'),
                thread: this.get('thread')
            });

            if (this.get('fileTemp')) {
                let fileObj = this.get('createFileAction')(this.get('fileTemp'));
                message.set('file', fileObj);
            }

            this.showLoader();
            message.save().then(() => {
                this.toast.success('models.message.save');
                this.set('messageBody', null);
                this.disableLoader();
            }, (response) => {
                this.processErrors(response.errors);
                this.disableLoader();
            });
        },

        toggleAttachDropzone() {
            this.toggleProperty('hideAttachDropzone');
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
        },
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