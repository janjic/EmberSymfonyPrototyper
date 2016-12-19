import Ember from 'ember';
import LoadingStateMixin from '../../mixins/loading-state';
import ReverseLoadingMixin from '../../mixins/messages-listing-inverse-load';
import { task, timeout } from 'ember-concurrency';

const { ApiCode, Translator } = window;

export default Ember.Component.extend(LoadingStateMixin, ReverseLoadingMixin, {
    /** ids used for pagination */
    _minId: undefined,
    _maxId: undefined,

    /** id of scroll container - used in inverse load mixin */
    scrollContainer: '#messages-list',

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
        this.set('_minId', undefined);
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
                this.get('messages').insertAt(0, message);
                this.set('_maxId', message.get('id'));
                this.toast.success('models.message.save');
                this.set('messageBody', null);
                this.set('fileTemp', null);
                /** push event to event bus to empty dropzone */
                this.get('eventBus').publish('emptyDropzone');
                this.scrollToBottom();
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
        this.set('_modelPath', 'messages');
        this.infinityModel("message", { perPage: 10, thread: this.get('thread.id') }, {
            min_id: '_minId',
        }).then((messages) => {
            this.set('messages', messages.toArray());
            this.set('_maxId', messages.get('firstObject.id'));
            this.disableLoader();
        }, () => {
            this.set('messages', []);
            this.disableLoader();
        });
    },

    getNewMessages: task(function * () {
        while (true) {
            yield timeout(5000);
            this.get('store').query('message', {per_page: 10, thread: this.get('thread.id'), max_id: this.get('_maxId')})
                .then((messages) => {
                    if(messages.toArray().length && this.get('messages')){
                        this.get('messages').pushObjects(messages.toArray());
                        this.set('_maxId', messages.get('firstObject.id'));
                    }
                });
        }
    }).on('init'),

});
