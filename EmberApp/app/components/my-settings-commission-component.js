import Ember from 'ember';
import CommissionValidations from '../validations/commission';
import Changeset from 'ember-changeset';
import lookupValidator from './../utils/lookupValidator';

export default Ember.Component.extend({
    CommissionValidations,

    init(){
        this._super(...arguments);
        this.changeset = new Changeset(this.get('commission'), lookupValidator(CommissionValidations), CommissionValidations);
    },

    actions: {
        validateProperty(changeset, property) {
            let valid = changeset.validate(property);
            this.get('setValid')( changeset.get('isValid'), this.get('index') );
            return valid;
        }
    }
});
