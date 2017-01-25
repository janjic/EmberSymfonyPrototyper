import Ember from 'ember';
import AuthenticatedRouteMixin from 'ember-simple-auth/mixins/authenticated-route-mixin';
const { service } = Ember.inject;
export default Ember.Mixin.create(AuthenticatedRouteMixin, {
    init() {
        this._super(...arguments);
    },
    acl: service('access-controll'),
    currentUser: service('current-user'),
    session: service(),
    redirect() {
        let [ , transition ] = arguments;
        let user = this.get('currentUser.user');

        this.get('acl').can('access_to_route', this.get('routeName'), this.get('currentUser.user'), transition.targetName).
        then(() => this._super(...arguments),()=> {
            if (user.get('roles').includes('ROLE_SUPER_ADMIN')) {
                this.transitionTo('dashboard.home');
            } else {
                this.transitionTo('dashboard.agent.home');
            }
        });
    },
    afterModel () {

    }
});
