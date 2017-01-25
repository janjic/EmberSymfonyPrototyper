import Ember from 'ember';

export function printCustomDate(params) {
    if( params[0] ) {
        if (params[1]) {
            return params[0].split(' ')[0];
        }
        return params[0].split('.')[0];
    }
    return '';
}

export default Ember.Helper.helper(printCustomDate);
