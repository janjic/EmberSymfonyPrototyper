import Ember from 'ember';
import PaymentInfoListingMixin from './../../../../mixins/payment-info-listing';

export default Ember.Controller.extend(PaymentInfoListingMixin, {
    actions: {
        filterModel (searchArray, page) {
            return this.get('store').query('payment-info', {
                page: page,
                offset: this.get('offset'),
                sidx: 'id',
                sord: 'desc',
                filters: JSON.stringify(searchArray)
            });
        }
    }
});