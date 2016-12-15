import Ember from 'ember';

export default Ember.Component.extend({
    currentUser: Ember.inject.service('current-user'),

    actions: {
        threadSelected(thread) {
            this.get('threadSelectedAction')(thread);
        }
    }
});