import Ember from 'ember';

export default Ember.Route.extend({
    model() {
        return new Ember.RSVP.Promise(resolve => {
            this.store.findAll('role').then(items => {
                resolve(items.filter((item) => {
                    return !item.get('parent').get('id');
                }));
            });
        });
    }
});
