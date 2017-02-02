import Ember from 'ember';

export default Ember.Controller.extend({
    actions:{
        transitionTo(link, agent_id){
            if( agent_id ){
                this.transitionToRoute(link, agent_id);
            } else{
                this.transitionToRoute(link);
            }
        }
    }
});
