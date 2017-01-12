import Ember from 'ember';
const { inject: { service }} = Ember;
const { Routing } = window;

export default Ember.Controller.extend({
    authorizedAjax:      service('authorized-ajax'),
    currentUser:         service('current-user'),
    newAgentsLoading:    true,
    newAgentsInfo:       {},
    newUsersInfoLoading: true,
    newUsersInfo:        {},
    newOrdersInfoLoading:true,
    newOrdersInfo:       {},

    actions: {
        getLatestOrders(){
            let agentId = this.get('currentUser.user.agentId');
            let orders =  this.store.query('customer-order', {
                page: 1,
                offset: 4,
                sidx: 'id',
                sord: 'desc',
                filters : {
                    groupOp: 'AND',
                    rules: [
                        {  field: 'user.agent.agent_id',
                            op: 'cn',
                            data: agentId
                        }
                    ]
                }
            });

            return Ember.RSVP.hash({
                orders
            });
        },

        getNumberOfNewAgents(){
            let agentId = this.get('currentUser.user.id');
            let ctx = this;

            this.get('authorizedAjax').sendAuthorizedRequest(null, 'GET', Routing.generate('new-agents-info', { id: agentId }),
                function (response) {
                    ctx.set('newAgentsLoading', false);
                    ctx.set('newAgentsInfo', response.data);
                });
        },

        getNumberOfNewUsers(){
            let agentId = this.get('currentUser.user.id');
            let ctx = this;

            this.store.queryRecord('info-widget', { type: 'users', agentId: agentId }).then((response)=>{
                ctx.set('newUsersInfoLoading', false);
                ctx.set('newUsersInfo', response);
            });
        },

        getNumberOfNewOrders(){
            let agentId = this.get('currentUser.user.id');
            let ctx = this;

            this.store.queryRecord('info-widget', { type: 'orders', agentId: agentId }).then((response)=>{
                ctx.set('newOrdersInfoLoading', false);
                ctx.set('newOrdersInfo', response);
            });
        }
    }
});
