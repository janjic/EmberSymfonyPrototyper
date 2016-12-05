import {
    validateLength
} from 'ember-changeset-validations/validators';
import NewPasswordValidation from './new-password';
import Ember from 'ember';
const { assign } = Ember;

export const ChangePasswordValidation = {
    oldPassword: [
        validateLength({ min: 6 })
    ],
};

export default assign({}, NewPasswordValidation, ChangePasswordValidation);