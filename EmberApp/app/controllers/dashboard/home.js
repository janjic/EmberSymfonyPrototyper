import Ember from 'ember';

export default Ember.Controller.extend({
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
        getAgentsByCountry(){
            
        }
    }
});
