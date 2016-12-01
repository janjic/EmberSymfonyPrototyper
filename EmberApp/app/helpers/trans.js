import Ember from 'ember';
const Translator = window.Translator;

export function trans([value], namedArgs) {
  return Translator.trans(value, namedArgs);
}

export default Ember.Helper.helper(trans);
