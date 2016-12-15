import Ember from 'ember';
import LoadingStateMixin from '../../../mixins/loading-state';
import { task, timeout } from 'ember-concurrency';

export default Ember.Component.extend(LoadingStateMixin, {
    currentUser: Ember.inject.service('current-user'),
    replyMessage: '',
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
            })
        },
        replyToTicket(){
            let threadObj = null;
            if(!this.get('model.thread.id')){
                threadObj = this.get('createNewThread')();
                this.set('model.thread', threadObj);
            }
            let message = this.get('createNewMessage')();
            message.set('sender', this.get('currentUser.user'));
            message.set('body', this.get('replyMessage'));
            this.get('model.thread.messages').pushObject(message);
            console.log(this.get('model.thread.messages').objectAt(0));
            console.log(this.get('model.thread.messages').objectAt(0).get('body'));
            let thread =  this.get('model.thread');
            thread.set('createdBy', this.get('model.createdBy'));
            message.save().then(()=>{
                console.log('sacuvao message');
            }, (response) => {
                console.log('nije');
            });

        }
    }
});
