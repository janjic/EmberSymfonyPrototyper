import Ember from 'ember';

export default Ember.Component.extend({
    currencies: [
        'EUR',
        'CHF'
    ],

    selectedCurrency: null,

    actions: {
        changeCurrency: function (val) {
            this.get('onCurrencyChange')(val);
        }
    }

});
