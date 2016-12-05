import Ember from 'ember';

export default Ember.Route.extend({
    model: function () {
        return this.store.query('tcr-user', {
            page: 1,
            offset: 10,
            sidx: 'id',
            sord: 'asc'
        });
    },
    setupController: function(controller, model) {
        this._super(controller, model);
        controller.set('maxPages', model.meta.pages);
        controller.set('totalItems', model.meta.totalItems);
    }
});