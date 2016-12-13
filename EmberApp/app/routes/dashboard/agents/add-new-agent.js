import Ember from 'ember';
export default Ember.Route.extend({

    model() {
        let agent = this.store.createRecord('agent');
        let address = this.store.createRecord('address');
        agent.set('address', address);

        return agent;


    },

});
