import Ember from 'ember';
import LoadingStateMixin from '../../mixins/loading-state';
import ReveseLoadingMixin from '../../mixins/messages-listing-inverse-load';

const { ApiCode, Translator } = window;

export default Ember.Component.extend(LoadingStateMixin, ReveseLoadingMixin, {
    /** id used for pagination */
    _minId: undefined,

    /** InfinityRoute mixin requires store */
    store: Ember.inject.service('store'),

    /** list of messages to be displayed */
    messages: [],
    sortProperties: ['id:asc'],
    messagesInverse: Ember.computed.sort('messages', 'sortProperties'),

    /** create new message attributes */
    messageBody: '',
    sendBtnDisabled: Ember.computed.empty('messageBody'),

    hideAttachDropzone: true,
    messageBodyChange: Ember.observer('messageBody', function () {
        this.set('hideAttachDropzone', true);
    }),
    currentUser: Ember.inject.service('current-user'),
    eventBus: Ember.inject.service('event-bus'),
    fileTemp: null,

    threadChange: Ember.observer('thread', function () {
        this._initialLoad();
        this._resetInverseLoadParams();
    }),

    didInsertElement(){
        this._super(...arguments);
        this._initialLoad();
    },

    actions:{
        /** create message and file if it is present and save it */
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
                // this.get('messages').insertAt(0, message);
                this.toast.success('models.message.save');
                this.set('messageBody', null);
                this.set('fileTemp', null);
                /** push event to event bus to empty dropzone */
                this.get('eventBus').publish('emptyDropzone');
                this.disableLoader();
            }, (response) => {
                message.deleteRecord();
                this.processErrors(response.errors);
                this.disableLoader();
            });
        },

        /** if thread is not deleted delete it, but if it is deleted remove it from trash */
        deleteThread() {
            let thread = this.get('thread');
            thread.set('changeDeleted', true);
            this.showLoader();

            thread.save().then(() => {
                if (this.get('isDeletedDisplay')) {
                    this.toast.success('models.message.undo');
                } else {
                    this.toast.success('models.message.delete');
                }
                this.get('deleteThreadAction')(thread);
                this.disableLoader();
            }, (response) => {
                this.processErrors(response.errors);
                this.disableLoader();
            });
        },

        /** control dropzone show/hide */
        toggleAttachDropzone() {
            this.toggleProperty('hideAttachDropzone');
        },

        /** when file is added create hash for it */
        addedFile (file) {
            let reader = new FileReader();
            this.set('fileTemp', {name: file.name});
            reader.onloadend = () => {
                this.set('fileTemp.base64Content', reader.result);
            };
            reader.readAsDataURL(file);
        },

        /** clear hash value for file */
        removedFile() {
            this.set('fileTemp', null);
        },
    },

    /**
     * Display message depending on error code
     * @param errors
     */
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

    /**
     * Load messages using infinity loader
     * @private
     */
    _initialLoad() {
        this.set('messages', null);
        this.showLoader();
        this.infinityModel("message", { perPage: 10, thread: this.get('thread.id') }, {
            min_id: '_minId',
        }).then((messages) => {
            this.set('messages', messages);
            this.set('_modelPath', 'messages');
            this.disableLoader();
        }, () => {
            this.set('messages', []);
            this.disableLoader();
        });
    },
});