import Ember from 'ember';

export default Ember.Controller.extend({
    selectedThread: null,

    actions: {
        threadSelected (thread) {
            this.set('selectedThread', thread);
        },
    }
});
