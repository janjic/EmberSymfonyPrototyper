// app/routes/application.js
import Ember from 'ember';
import ApplicationRouteMixin from 'ember-simple-auth/mixins/application-route-mixin';
import Translator from 'npm:bazinga-translator';

const { service } = Ember.inject;

export default Ember.Route.extend(ApplicationRouteMixin, {
    currentUser: service('current-user'),
    ajax: service('ajax'),
    beforeModel() {
       //  this.get('ajax').request('/translations/messages.json?locales=sr').then(translations => {
       //      Translator.fromJSON(translations);
       //  });
       //  Translator.lolale = 'en';
       // console.log(Translator.trans('HOME'));
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