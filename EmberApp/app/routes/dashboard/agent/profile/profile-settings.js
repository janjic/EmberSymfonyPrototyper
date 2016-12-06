import Ember from 'ember';
const { service } = Ember.inject;
export default Ember.Route.extend({
    currentUser: service('current-user'),
    actions: {
        willTransition(transition) {
            let user = this.get('currentUser.user');
            if (user.get('roles').includes('ROLE_SUPER_ADMIN')) {
                transition.abort();
                this.transitionTo('dashboard.home');
            } else {
                return true;

            }
        }
    }

});
