import Ember from 'ember';
import BonusValidations from '../validations/bonus';
import Changeset from 'ember-changeset';
import lookupValidator from './../utils/lookupValidator';

export default Ember.Component.extend({
    BonusValidations,

    init(){
        this._super(...arguments);
        this.changeset = new Changeset(this.get('bonus'), lookupValidator(BonusValidations), BonusValidations);
    },

    actions: {
        validateProperty(changeset, property) {
            let valid = changeset.validate(property);
            this.get('setValid')( changeset.get('isValid'), this.get('index') );
            return valid;
        }
    }
});
