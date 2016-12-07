import Ember from 'ember';

export default Ember.Route.extend({
    model: function () {
        let agent = this.store.createRecord('agent');
        let image = this.store.createRecord('image');
        let address = this.store.createRecord('address');

        agent.set('image', image);
        agent.set('address', address);
        return agent;
    }
});
