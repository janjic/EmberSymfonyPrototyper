import Ember from 'ember';
import CommissionValidations from '../validations/commission';
import Changeset from 'ember-changeset';
//import lookupValidator from './../utils/lookupValidator';
import lookupValidator from 'ember-changeset-validations';

export default Ember.Component.extend({
    CommissionValidations,

    init(){
        this._super(...arguments);
        this.changeset = new Changeset(this.get('commission'), lookupValidator(CommissionValidations), CommissionValidations);
        this.get('registerChangeset')(this.changeset);
    },

    actions: {
        validateProperty(changeset, property) {
            return changeset.validate(property);
            //let valid = changeset.validate(property);
            //this.get('setValid')( changeset.get('isValid'), this.get('index') );
            //return valid;
        }
    }
});
