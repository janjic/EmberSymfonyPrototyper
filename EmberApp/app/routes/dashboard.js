import Ember from 'ember';
import AuthenticatedRouteMixin from 'ember-simple-auth/mixins/authenticated-route-mixin';
import Configuration from 'ember-simple-auth/configuration';
const { service } = Ember.inject;
const { Route } = Ember;

export default Route.extend(AuthenticatedRouteMixin, {
    currentUser: service('current-user'),
    beforeModel(transition) {
        if (!this.get('session.isAuthenticated')) {
            Ember.assert('The route configured as Configuration.authenticationRoute cannot implement the AuthenticatedRouteMixin mixin as that leads to an infinite transitioning loop!', this.get('routeName') !== Configuration.authenticationRoute);
            transition.abort();
            this.set('session.attemptedTransition', transition);
            this.transitionTo(Configuration.authenticationRoute);
        } else {
            let currentUser = this.get('currentUser');
            console.log('User id je', currentUser.get('user.id'));
            this.transitionTo('dashboard.home');
        }
    }
});