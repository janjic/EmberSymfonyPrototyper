import Ember from 'ember';

export default Ember.Route.extend({
    model: function () {
        return this.get('store').query('agent', {
            page: 1,
            offset: 10,
            sidx: 'id',
            sord: 'asc'
        });
    }
});
