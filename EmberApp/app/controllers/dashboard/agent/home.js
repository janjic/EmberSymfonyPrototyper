import Ember from 'ember';

export default Ember.Controller.extend({
    currentUser: Ember.inject.service('current-user'),
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
        }
    }
});
