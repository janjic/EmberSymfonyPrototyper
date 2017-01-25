import Ember from 'ember';
const { service } = Ember.inject;

export default Ember.Route.extend({
    currentUser: service('current-user'),
    model: function () {
        return this.get('store').query('ticket', {
            page: 1,
            offset: 10,
            sidx: 'id',
            sord: 'desc',
            additionalData: {ticketsType: 'forwardedTo', agentId: 'null'}
        });

    },
    setupController : function(controller, model){
        this._super(...arguments);
        controller.set('maxPages', model.meta.pages);
        controller.set('totalItems', model.meta.totalItems);
        controller.set('page', 1);
        controller.set('offset', 10);
        controller.set('searchArray', {
            groupOp:"AND",
            rules: []
        });
    }
});
