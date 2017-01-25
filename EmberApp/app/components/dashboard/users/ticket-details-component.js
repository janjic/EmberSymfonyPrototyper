import Ember from 'ember';
import LoadingStateMixin from '../../../mixins/loading-state';
const {Translator, ApiCode }= window;
import { task, timeout } from 'ember-concurrency';

export default Ember.Component.extend(LoadingStateMixin, {
    currentUser: Ember.inject.service('current-user'),
    replyMessage: '',
    disableWriteByUser: Ember.computed('currentUser.user', 'model.forwardedTo', function () {
        if (!this.get('model.forwardedTo')) {
            return false;
        } else {
            let isForwardedTo = this.get('model.forwardedTo.id') === this.get('currentUser.user.id');
            let isCreatedBy = this.get('model.createdBy.id') === this.get('currentUser.user.id');
            return !(isForwardedTo || isCreatedBy);
        }
    }),

    search: task(function * (text, page, perPage) {
        yield timeout(200);
        return this.get('searchQuery')(page, text, perPage);
    }),
    actions: {
        agentSelected(agent){
            this.set('model.forwardedTo', agent);
            this.send('editTicket');
        },
        editTicket(){
            this.showLoader('loading.sending.data');
            this.model.save().then( () => {
                this.toast.success(Translator.trans('models.ticket.save.message'));
                this.disableLoader();
            }, (response) => {
                response.errors.forEach((error)=>{
                    switch (parseInt(error.status)) {
                        case ApiCode.FILE_SAVING_ERROR:
                            this.toast.error(Translator.trans('models.agent.file.error'));
                            break;
                        case ApiCode.ERROR_MESSAGE:
                            this.toast.error(Translator.trans(error.detail));
                            break;
                        default:
                            return;
                    }
                    this.disableLoader();
                });
            });
        },
        createMessage(hash){
            return this.get('createNewMessage')(hash);

        },

        statusChanged(status){
            if( status ) {
                this.set('model.status', status);
                this.send('editTicket');
            }
        }
    }
});
