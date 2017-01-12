import Ember from 'ember';
const { inject: { service }} = Ember;
const { Routing } = window;

export default Ember.Controller.extend({
    authorizedAjax:       service('authorized-ajax'),
    currentUser:          service('current-user'),
    newAgentsLoading:     true,
    newAgentsInfo:        {},
    newUsersInfoLoading:  true,
    newUsersInfo:         {},
    newOrdersInfoLoading: true,
    newOrdersInfo:        {},

    actions: {
        getLatestOrders(){
            let orders =  this.store.query('customer-order', {
                page: 1,
                offset: 4,
                sidx: 'id',
                sord: 'desc',
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
            let ctx = this;
            this.store.queryRecord('info-widget', { type: 'users' }).then((response)=>{
                ctx.set('newUsersInfoLoading', false);
                ctx.set('newUsersInfo', response);
            });
        },

        getNumberOfNewOrders(){
            let ctx = this;

            this.store.queryRecord('info-widget', { type: 'orders' }).then((response)=>{
                ctx.set('newOrdersInfoLoading', false);
                ctx.set('newOrdersInfo', response);
            });
        },

        getNumberOfNewCommissions(){

        },
        getAgentsByCountry(){

        }
    },

    init(){
        let agentId = this.get('currentUser.user.id');
        this.get('authorizedAjax').sendAuthorizedRequest(null, 'GET', Routing.generate('new-payments-info', { id: agentId }),
            function (response) {
                console.log('stigao odg');
            });
    }
});
