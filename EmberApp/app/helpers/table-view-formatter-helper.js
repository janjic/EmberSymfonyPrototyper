import Ember from 'ember';

export function tableViewFormatterHelper(params) {
    return typeof params[0] === 'function' ? params[0](params[1]) : params[1];
}
export default Ember.Helper.helper(tableViewFormatterHelper);
