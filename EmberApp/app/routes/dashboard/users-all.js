import Ember from 'ember';

export default Ember.Route.extend({
    page: 1,
    offset: 10,
    model: function () {
        return this.store.query('user', {
            page: this.get('page'),
            offset: this.get('offset')
        });
    }
});
