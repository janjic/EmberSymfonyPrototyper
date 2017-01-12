import Ember from 'ember';

export default Ember.Component.extend({
    orders: [],
    isLoading: true,
    didInsertElement(){
        this._super(...arguments);
        this.get('getOrders')().then((result) => {
            this.set('orders', result.orders);
            this.set('isLoading', false);
        });
    }
});
