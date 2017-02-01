import Ember from 'ember';

export default Ember.Route.extend({
    model(params) {
        if (params.agentId) {
            return this.store.findRecord('agent', params.agentId);
        }
    }
});
