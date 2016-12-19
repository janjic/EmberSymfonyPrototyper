import Ember from 'ember';
import InfinityRoute from "ember-infinity/mixins/route";

export default Ember.Mixin.create(InfinityRoute, {
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
        },
    }
});
