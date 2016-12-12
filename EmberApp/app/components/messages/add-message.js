import Ember from 'ember';
import { task, timeout } from 'ember-concurrency';

const { inject: { service }} = Ember;

export default Ember.Component.extend({
    authorizedAjax: service('authorized-ajax'),
    currentUser: Ember.inject.service('current-user'),
    store: service('store'),
    participant: null,
    searchTask: task(function* (term) {
        yield timeout(1500);
    }),

    actions: {
        sendMessage() {

            // var agentPromise = this.get('store').findRecord('agent', elementId);
            //
            // Ember.RSVP.allSettled([newParentPromise, agentPromise]).then(([npPromise, agPromise]) => {
            //
            // };
            //
            // this.get('store').findRecord('agent', 30).then((res) => {
            //     this.set('participant',  res);
            //
            //     console.log(this.get('participant'));
            //
            //     let message = this.get('store').createRecord('message', {
            //         sender:         this.get('currentUser.user'),
            //         participants:   [participant],
            //         body:           this.get('body')
            //     });
            //
            //     let thread = this.get('store').createRecord('thread', {
            //         createdBy:      this.get('currentUser.user'),
            //         participants:   [participant],
            //         subject:        this.get('subject'),
            //         messages:       [message]
            //     });
            // });


            //
            // console.log('asddsads');
            console.log(thread);

            // let threadMetadata = this.get('store').createRecord('thread-metadata', {
            //     'participant': this.get('store').findRecord('agent', 30),
            // });
            //
            //
            // let thread = this.get('store').createRecord('thread', {
            //     'createdBy': this.get('currentUser.user'),
            //     'threadMetadata': [threadMetadata],
            //     'subject': this.get('subject'),
            // });
            //
            // console.log(thread);
            // let messageMetadata = this.get('store').createRecord('message-metadata', {
            //     'participant': this.get('store').findRecord('agent', 30),
            //
            // });
            //
            // let message = this.get('store').createRecord('message', {
            //     'sender': this.get('currentUser.user'),
            //     'body': this.get('body')
            // });
            //
            // console.log(message);
            // message.save().then((res) => {
            //     console.log(res);
            // }, (res) => {
            //     console.log(res);
            // });

            //     console.log('sendMessage');
            //     console.log();
            //     console.log(this.get('body'));
        }
    }
});