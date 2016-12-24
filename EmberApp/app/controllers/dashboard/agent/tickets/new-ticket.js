import Ember from 'ember';
const { service } = Ember.inject;

export default Ember.Controller.extend({
    actions: {
        goToRoute (route) {
            this.transitionToRoute(route);
        },
    }


});