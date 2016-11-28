import Ember from 'ember';
import AuthenticatedRouteMixin from 'ember-simple-auth/mixins/authenticated-route-mixin';
import Configuration from 'ember-simple-auth/configuration';
const { service } = Ember.inject;
export default Ember.Mixin.create(AuthenticatedRouteMixin, {
    init() {
        this._super(...arguments);
    },
    acl: service('access-controll'),
    currentUser: service('current-user'),
    beforeModel(transition) {
        if (!this.get('session.isAuthenticated')) {
            Ember.assert('The route configured as Configuration.authenticationRoute cannot implement the AuthenticatedRouteMixin mixin as that leads to an infinite transitioning loop!', this.get('routeName') !== Configuration.authenticationRoute);
            transition.abort();
            this.set('session.attemptedTransition', transition);
            this.transitionTo(Configuration.authenticationRoute);

        } else {
            this.get('acl').can(this.get('currentUser.user.username'), this.get('routeName')).
                    then(() => this._super(...arguments),()=> transition.abort() && this.transitionTo('error'));
        }
    }
});
