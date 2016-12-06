import Ember from 'ember';
export default Ember.Controller.extend({

    actions: {
        gotToLogin() {
            this.transitionToRoute('login');
        }
    }
});
