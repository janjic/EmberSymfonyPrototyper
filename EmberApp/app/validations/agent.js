import {
    validateFormat,
    validatePresence,
    validateConfirmation,
    validateLength
} from 'ember-changeset-validations/validators';

export default {
    agentID: validatePresence(true),
    firstName: validatePresence(true),
    lastName: validatePresence(true),
    phoneNumber: validateFormat({regex: /\+(([0-9]{3})|([0-9]{2}))\s?(([0-9]{3})|([0-9]{2}))\s?[0-9]{3}\s?[0-9]{2}\s?[0-9]{2}/}),
    email: validateFormat({ type: 'email' }),
    emailRepeat: validateConfirmation({on: 'email'}),
    privateEmail: validateFormat({ type: 'email' }),
    plainPassword: validateLength({min: 5}),
    passwordRepeat: validateConfirmation({on: 'plainPassword'}),

};