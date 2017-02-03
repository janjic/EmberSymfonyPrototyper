import Ember from 'ember';

export default Ember.Route.extend({
    model: function () {
        return this.store.query('tcr-user', {
            page: 1,
            offset: 8,
            sidx: 'id',
            sord: 'asc'
        });
    },
    setupController: function(controller, model) {
        this._super(controller, model);
        controller.set('maxPages', model.meta.pages);
        controller.set('totalItems', model.meta.totalItems);
        controller.set('agentId', undefined);
        controller.set('searchArray', undefined);
        controller.set('page', 1);
        controller.set('offset', 8);
        // controller.set('agents', this.store.findAll('agent'));
    },

    actions: {
        willTransition() {
            // this.controller.set('agentId', undefined);
            // this.controller.set('searchArray', undefined);
            // this.controller.set('page', 1);
            // this.controller.set('offset', 8);
        }
    }
});