import Ember from 'ember';

const { inject: { service }, isEmpty, RSVP } = Ember;

export default Ember.Service.extend({
    session: service('session'),
    store: service(),

    load() {
        console.log('Usao');
        return new RSVP.Promise((resolve, reject) => {
            let userId = this.get('session.data.authenticated.account_id');
            console.log('User id je', userId);
            if (!isEmpty(userId)) {
                this.get('store').find('user', userId).then((user) => {
                    this.set('user', user);
                    resolve();
                }, reject);
            } else {
                resolve();
            }
        });
    }
});