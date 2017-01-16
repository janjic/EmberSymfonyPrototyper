import Ember from 'ember';

export function printCustomDate(params) {
    return params[0].split('.')[0];
}

export default Ember.Helper.helper(printCustomDate);
