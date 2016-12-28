import Ember from 'ember';

export default Ember.Controller.extend({
    actions:{
        transitionTo(link, newAgent){
            let agent_id = newAgent ? newAgent.get('id') : undefined;

            if( link ) {
                if ( agent_id ) {
                    this.transitionToRoute(link, agent_id );
                } else {
                    this.transitionToRoute(link);
                }
            }
        }
    }
});
