import Ember from 'ember';
const { inject: { service }, Component } = Ember;

export default Component.extend({
    session: service('session'),
    actions: {
        logout() {
            this.get('session').invalidate();
        }
    }

});
