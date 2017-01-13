import Ember from 'ember';

export default Ember.Route.extend({
    model: function () {
        return this.get('store').query('payment-info', {
            page: 1,
            offset: 8,
            sidx: 'id',
            sord: 'desc',
            paymentState: 'false'
        });
    },

    setupController : function(controller, model){
        this._super(...arguments);
        controller.set('maxPages', model.meta.pages);
        controller.set('totalItems', model.meta.totalItems);
        controller.set('paymentState', 'false');
    }
});
