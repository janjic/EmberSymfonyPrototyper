import Ember from 'ember';
const Translator = window.Translator;
const {
    inject: {
        service
    }
} = Ember;
export default Ember.Helper.extend({
    session: service('session'),
    compute([value], namedArgs) {
        Translator.locale = this.get('session.data.locale');
        return Translator.trans(value, namedArgs);
    }
});
