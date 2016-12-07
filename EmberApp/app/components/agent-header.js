import Ember from 'ember';
const { inject: { service }, Component, computed } = Ember;

export default Component.extend({
    session: service('session'),
    profileRoute: computed('user',function () {
        if (this.get('user.roles').includes('ROLE_SUPER_ADMIN')) {
                return 'dashboard.profile-settings';
        }
        return 'dashboard.agent.profile.profile-settings';
    }),
    actions: {
        logout() {
            this.get('session').invalidate();
        }
    }

});
