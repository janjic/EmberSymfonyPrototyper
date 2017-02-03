import Ember from 'ember';
import BonusValidations from '../validations/bonus';
import Changeset from 'ember-changeset';
//import lookupValidator from './../utils/lookupValidator';
import lookupValidator from 'ember-changeset-validations';

export default Ember.Component.extend({
    BonusValidations,

    init(){
        this._super(...arguments);
        this.changeset = new Changeset(this.get('bonus'), lookupValidator(BonusValidations), BonusValidations);
        this.get('registerChangeset')(this.changeset);
    },

    actions: {
        validateProperty(changeset, property) {
            return changeset.validate(property);
            //let valid = changeset.validate(property);
            //this.get('setValid')( changeset.get('isValid'), this.get('index') );
            //return valid;
        },

        currencyChanged(val) {
            this.set('bonus.currency', val);
        }
    }
});
