import Ember from 'ember';

export default Ember.Controller.extend({
    actions: {
        goToRoute(route){
            this.transitionToRoute(route);
        }
    }
});
