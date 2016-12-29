import Ember from 'ember';

export function sum(params) {

    let result = 0;
    params.forEach(function (item) {
        result +=item;
    });

    return result;
}

export default Ember.Helper.helper(sum);
