import Ember from 'ember';

export default Ember.Route.extend({
    model: function () {
        let agent = this.store.createRecord('agent');
        let address = this.store.createRecord('address');
        agent.set('address', address);
        return agent;
    }
});
