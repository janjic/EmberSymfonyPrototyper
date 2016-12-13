import Ember from 'ember';
import InfinityRoute from "ember-infinity/mixins/route";
export default Ember.Route.extend(InfinityRoute,{

    model() {
        let agent = this.store.createRecord('agent');
        let address = this.store.createRecord('address');
        agent.set('address', address);
        return Ember.RSVP.hash({
            agent,
            agents: this.infinityModel('agent', {
                 perPage: 3,
                startingPage: 1 ,
                modelPath: 'controller.agents'

            })
        });


    },

    afterInfinityModel(model) {
        console.log('Usao');
    },

    setupController(controller, model) {
        this._super(...arguments);
        controller.setProperties(model);

    }

});
