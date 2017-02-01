import Ember from 'ember';
import { task} from 'ember-concurrency';

export default Ember.Component.extend({
    orders: [],
    isLoading: true,
    didInsertElement(){
        this._super(...arguments);
        this.get('setUp').perform();
    },

    setUp: task(function * () {
        let result = yield this.get('getOrders')();

        this.set('orders', result.orders);
        this.set('isLoading', false);

    }).restartable(),
});
