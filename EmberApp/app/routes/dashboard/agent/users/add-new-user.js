import Ember from 'ember';

export default Ember.Route.extend({
    model: function () {
        let user = this.store.createRecord('tcr-user');
        let address = this.store.createRecord('address');
        let image = this.store.createRecord('image');
        user.set('address', address);
        user.set('image', image);

        return user;
    }
});
