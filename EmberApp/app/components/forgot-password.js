import Ember from 'ember';
import ForgotPasswordValidations from '../validations/forgot-password';

export default Ember.Component.extend({
    validations: ForgotPasswordValidations,
    email: '',
    init() {
        this._super(...arguments);
    },
    actions: {
        reset(changeset) {
            return changeset.rollback();
        },
        validateProperty(changeset, property) {
            console.log(changeset);
            return changeset.validate(property);
        }
    }
});
