import Ember from 'ember';
const {
    inject: {
        service
    }
} = Ember;

export default Ember.Route.extend({
    currentUser: service('current-user'),
    model(params) {
        return this.store.findRecord('tcrUser', params.id);
    },

    afterModel(model) {
        if (!Object.is(model.get('agent.id'), this.get('currentUser.user.id'))) {
            this.transitionTo('dashboard.agent.users.users-customers');
        }

    }

});