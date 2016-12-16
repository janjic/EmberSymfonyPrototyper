import Ember from 'ember';

export default Ember.Controller.extend({
    selectedThread: null,

    actions: {
        threadSelected (thread) {
            this.set('selectedThread', thread);
        },

        createMessage(hash) {
            return this.get('store').createRecord('message', hash);
        },

        createFile(hash) {
            return this.get('store').createRecord('file', hash);
        },

        deleteThread(thread) {
            this.set('selectedThread', null);
            this.get('model').removeObject(thread);
        }
    }
});
