import Ember from 'ember';

const { inject: { service }, isEmpty, RSVP } = Ember;

export default Ember.Service.extend({
    session: service('session'),
    store: service('store'),

    load() {
        return new RSVP.Promise((resolve, reject) => {
            let userId = this.get('session.data.authenticated.account_id');
            if (!isEmpty(userId)) {
                this.get('store').findRecord('agent', userId).then((user) => {
                    this.set('user', user);
                    this.set('isUserAdmin', user.get('roles').includes('ROLE_SUPER_ADMIN'));
                    this.get('session').set('data.locale', user.get('nationality'));
                    resolve(user);
                }, reject);
            } else {
                resolve();
            }
        });
    }
});