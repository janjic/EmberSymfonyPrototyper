import Ember from 'ember';
const { inject: { service }} = Ember;
const { Routing } = window;

export default Ember.Controller.extend({
    authorizedAjax:             service('authorized-ajax'),
    currentUser:                service('current-user'),
    newAgentsLoading:           true,
    newAgentsInfo:              {},
    newUsersInfoLoading:        true,
    newUsersInfo:               {},
    newOrdersInfoLoading:       true,
    newOrdersInfo:              {},
    newCommissionsInfoLoading:  true,
    newCommissionsInfo:         [],
    isNewCommissionsInfoMultiple:true,
    newMessagesInfo:            {},
    newMessagesInfoLoading:     true,

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
            this.get('authorizedAjax').sendAuthorizedRequest(null, 'GET', Routing.generate('new-agents-information'),
                function (response) {
                    this.set('newAgentsLoading', false);
                    this.set('newAgentsInfo', response.data);
                }.bind(this), this);
        },

        getNumberOfNewUsers(){
            this.store.queryRecord('info-widget', { type: 'users' }).then((response)=>{
                this.set('newUsersInfoLoading', false);
                this.set('newUsersInfo', response);
            });
        },

        getNumberOfNewOrders(){
            this.store.queryRecord('info-widget', { type: 'orders' }).then((response)=>{
                this.set('newOrdersInfoLoading', false);
                this.set('newOrdersInfo', response);
            });
        },

        getNumberOfNewCommissions(){
            let ctx = this;

            this.get('authorizedAjax').sendAuthorizedRequest(null, 'GET', Routing.generate('new-payments-info'),
                function (response) {
                    let commArray = [];
                    for (let key in response.data) {
                        if (!response.data.hasOwnProperty(key)) {
                            continue;
                        }
                        commArray.push(response.data[key]);
                    }

                    if ( commArray.length > 1 ){
                        ctx.set('isNewCommissionsInfoMultiple', true);
                        ctx.set('newCommissionsInfo', commArray);
                    } else {
                        ctx.set('isNewCommissionsInfoMultiple', false);
                        ctx.set('newCommissionsInfo', commArray.shift());
                    }
                    ctx.set('newCommissionsInfoLoading', false);
                });
        },

        getNumberOfNewMessages(){
            let ctx = this;

            this.get('authorizedAjax').sendAuthorizedRequest(null, 'GET', Routing.generate('new-messages-info'),
                function (response) {
                    ctx.set('newMessagesInfoLoading', false);
                    ctx.set('newMessagesInfo', response.data);
                });
        },

        getAgentsByCountry(){

        }
    }
});
