import Ember from 'ember';

export default Ember.Route.extend({
    model: function () {
        var user = this.store.createRecord('user');
        var address = this.store.createRecord('address');
        var image = this.store.createRecord('image');
        user.set('address', address);
        user.set('image', image);
        return user;
        // {
            // user, image, address

        // };
    }
});
