// app/routes/application.js
import Ember from 'ember';
import ApplicationRouteMixin from 'ember-simple-auth/mixins/application-route-mixin';

const { service, computed } = Ember.inject;

export default Ember.Route.extend(ApplicationRouteMixin, {
    currentUser: service('current-user'),
    routeAfterAuthentication: 'simple',
    beforeModel() {
        return this._loadCurrentUser();
    },
    sessionAuthenticated() {
        console.log(this.get('routeAfterAuthentication'));
        const attemptedTransition = this.get('session.attemptedTransition');
        if (attemptedTransition) {
            attemptedTransition.retry();
            this.set('session.attemptedTransition', null);
        } else {
            this.transitionTo(this.get('routeAfterAuthentication'));
        }
        this._loadCurrentUser().catch(() => this.get('session').invalidate());
    },
    _loadCurrentUser() {
        return this.get('currentUser').load();
    }
});