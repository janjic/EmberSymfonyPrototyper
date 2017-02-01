import Ember from 'ember';
const Translator = window.Translator;
const {
    inject: {
        service
    }
} = Ember;
export default Ember.Helper.extend({
    session: service('session'),
    compute() {
        Ember.$(document).attr('title', Translator.trans('meta.title'));
    }
});

