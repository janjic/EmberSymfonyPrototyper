// app/routes/application.js
import Ember from 'ember';
import ApplicationRouteMixin from 'ember-simple-auth/mixins/application-route-mixin';
import moment from 'moment';
const {
    RSVP,
    computed,
    inject: {
        service
    }
    } = Ember;

export default Ember.Route.extend(ApplicationRouteMixin, {
    currentUser: service('current-user'),
    routeAfterAuthentication: computed('currentUser', function () {
        return this.get('currentUser.user.roles').includes('ROLE_SUPER_ADMIN') ? 'dashboard.home' :'dashboard.agent.home';

    }),
    beforeModel() {

        //download("base64","dlDataUrlBin.pdf", "application/pdf");
        return this._loadCurrentUser();
    },
    sessionAuthenticated() {
        //wait first for resolving loading promise then redirect
        new RSVP.Promise((resolve, reject) =>{
            this._loadCurrentUser().then(()=>  {
                resolve(true);
            }).catch(() => this.get('session').invalidate() && reject(false));
        }).then(()=>{
            this.transitionTo(this.get('routeAfterAuthentication'));
            const attemptedTransition = this.get('session.attemptedTransition');
            if (attemptedTransition) {
                attemptedTransition.retry();
                this.set('session.attemptedTransition', null);
            } else {
                this.transitionTo(this.get('routeAfterAuthentication'));
            }
        });

    },
    _loadCurrentUser() {
        moment.locale('de');
        return this.get('currentUser').load();
    }
});