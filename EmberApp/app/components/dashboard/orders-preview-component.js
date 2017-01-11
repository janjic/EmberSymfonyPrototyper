import Ember from 'ember';

export default Ember.Component.extend({
    orders: [],
    didReceiveAttrs(){
        this._super(...arguments);
        this.get('getOrders')().then((result) => {
            this.set('orders', result.orders);
        });
    }
});
