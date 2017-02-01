import Ember from 'ember';
const Translator = window.Translator;

export default Ember.Helper.extend({
    compute() {
        Ember.$(document).attr('title', Translator.trans('meta.title'));
    }
});

