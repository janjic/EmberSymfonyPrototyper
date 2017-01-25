import Ember from 'ember';

export default Ember.Route.extend({
    model() {
        return this.store.query('customer-order', {
            page: 1,
            offset: 10,
            sidx: 'id',
            sord: 'desc'
        }).then((response)=> {
            return response;
        });
    },
    setupController : function(controller, model){
        this._super(...arguments);
        controller.set('maxPages', model.meta.pages);
        controller.set('totalItems', model.meta.totalItems);
        controller.set('page', 1);
        controller.set('offset', 10);
        controller.set('agentId', undefined);
        controller.set('searchArray', {
            groupOp:"AND",
            rules: []
        });
    }
});
