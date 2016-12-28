import Ember from 'ember';

export default Ember.Route.extend({
    model() {
        return this.store.query('customer-order', {
            page: 1,
            offset: 10,
            sidx: 'id',
            sord: 'asc'
        }).then((response)=> {
            return response;
        });
    },
    setupController : function(controller, model){
        this._super(...arguments);
        controller.set('maxPages', model.meta.pages);
        controller.set('totalItems', model.meta.totalItems);
    }
});
