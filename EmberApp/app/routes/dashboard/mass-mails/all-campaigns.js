import Ember from 'ember';

export default Ember.Route.extend({
    model: function () {
        return this.get('store').query('mail-campaign', {
            page: 1,
            offset: 10,
            sidx: 'id',
            sord: 'asc',
        });

    },
    setupController : function(controller, model){
        this._super(...arguments);
        controller.set('maxPages', model.meta.pages);
        controller.set('totalItems', model.meta.totalItems);
        controller.set('page', 1);
        controller.set('offset', 10);
    }
});
