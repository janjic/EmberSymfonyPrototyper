import Ember from 'ember';
import RSVP from 'rsvp';
export default Ember.Route.extend({

    model() {
        let agent = this.store.createRecord('agent');
        let address = this.store.createRecord('address');
        agent.set('address', address);

         return RSVP.hash({
            agent,
            groups:  this.get('store').findAll('group')
        });


    },

});
