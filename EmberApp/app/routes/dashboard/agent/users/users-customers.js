import Ember from 'ember';
const { service } = Ember.inject;

export default Ember.Route.extend({
    currentUser: service('current-user'),
    model: function () {
        let promoCode = this.get('currentUser.user.agentId');
        return this.store.query('tcr-user', {
            page: 1,
            offset: 8,
            sidx: 'id',
            sord: 'asc',
            agentId: promoCode
        });
    },
    setupController: function(controller, model) {
        this._super(controller, model);
        controller.set('maxPages', model.meta.pages);
        controller.set('totalItems', model.meta.totalItems);
        controller.set('agentId', this.get('currentUser.user.agentId'));
    }
});
