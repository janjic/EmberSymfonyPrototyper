import Ember from 'ember';

export function currencyForCountry(params) {
    if(params[0] === 'Switzerland'){
        return 'CHF'
    } else{
        return 'EUR';
    }
}

export default Ember.Helper.helper(currencyForCountry);
