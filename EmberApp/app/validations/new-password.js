import {
    validateLength,
    validateConfirmation
} from 'ember-changeset-validations/validators';

export default {
    password: [
        validateLength({ min: 6 })
    ],
    passwordConfirmation: validateConfirmation({ on: 'password' })
};