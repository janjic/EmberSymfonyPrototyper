import Ember from 'ember';

const { inject: { service }, isEmpty, RSVP } = Ember;

export default Ember.Service.extend({
    session: service('session'),
    store: service(),

    load() {
        return new RSVP.Promise((resolve, reject) => {
            let userId = this.get('session.data.authenticated.account_id');
            if (!isEmpty(userId)) {
                this.get('store').find('agent', userId).then((user) => {
                    this.set('user', user);
                    resolve();
                }, reject);
            } else {
                resolve();
            }
        });
    }
});