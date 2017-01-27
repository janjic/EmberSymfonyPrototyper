import Ember from 'ember';
const Translator = window.Translator;

export default Ember.Helper.helper(function(params) {
    Ember.$(document).attr('title', Translator.trans('meta.title'));
});

