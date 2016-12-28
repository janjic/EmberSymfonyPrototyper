import Ember from 'ember';

export function multiply(params) {
  let result = 1;
  params.forEach(function (item) {
     result *=item;
  });

  return result;
}

export default Ember.Helper.helper(multiply);
