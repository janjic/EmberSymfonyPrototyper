import Ember from 'ember';

export default Ember.Route.extend({
    currentUser: Ember.inject.service('current-user'),
    model() {
        let agentId = this.get('currentUser.user.agentId');
        return this.store.query('customer-order', {
            page: 1,
            offset: 10,
            sidx: 'id',
            sord: 'asc',
            filters : {
                groupOp: 'AND',
                rules: [
                    {  field: 'user.agent.agent_id',
                        op: 'cn',
                        data: agentId
                    }
                ]

            }
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
    }
});
