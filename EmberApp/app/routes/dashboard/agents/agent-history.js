import Ember from 'ember';
import RSVP from 'rsvp';

export default Ember.Route.extend({
    model(param){
        let history =  this.store.query('agent-history', {
            agentId: param.agentId
        }, { reload : true });

        let agent = this.store.findRecord('agent', param.agentId, { reload : true });

        return RSVP.hash({
           history, agent
        });
    }
});
