// app/routes/application.js
import Ember from 'ember';
import ApplicationRouteMixin from 'ember-simple-auth/mixins/application-route-mixin';

const { service } = Ember.inject;
const Translator    = window.Translator;
const Router        = window.Router;

export default Ember.Route.extend(ApplicationRouteMixin, {
    currentUser: service('current-user'),

    beforeModel() {
        return this._loadCurrentUser();
    },

    sessionAuthenticated() {
        this._super(...arguments);
        this._loadCurrentUser().catch(() => this.get('session').invalidate());
    },

    _loadCurrentUser() {
        return this.get('currentUser').load();
    }
});