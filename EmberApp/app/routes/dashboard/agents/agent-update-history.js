import Ember from 'ember';

export default Ember.Route.extend({
    model: function () {
        return this.get('store').query('agent-history', {
            page: 1,
            offset: 10,
            sidx: 'id',
            sord: 'desc',
            type: 'UPGRADE'
        });

    },
    setupController : function(controller, model){
        this._super(...arguments);
        controller.set('maxPages', model.meta.pages);
        controller.set('totalItems', model.meta.totalItems);
    }
});
