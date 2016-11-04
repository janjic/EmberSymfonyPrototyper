import Ember from 'ember';

const { inject: { service }, Component } = Ember;

export default Component.extend({
    session:        service('session'),
    currentUser: service('current-user'),

    actions: {
        login() {
            this.get('onLogin')();
        },

        logout() {
            this.get('session').invalidate();
        }
    }
});