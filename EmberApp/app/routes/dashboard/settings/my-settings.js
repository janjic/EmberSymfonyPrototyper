import Ember from 'ember';

export default Ember.Route.extend({
    model: function () {
        return this.store.findRecord('setting', 1, { reload: true });
    }
});
