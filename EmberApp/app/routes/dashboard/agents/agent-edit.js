import Ember from 'ember';
import RSVP from 'rsvp';
export default Ember.Route.extend({
    model: function (params) {
        return RSVP.hash({
            agent: this.store.findRecord('agent', params.id),
            groups:  this.get('store').findAll('group')
        });
    }
});
