import {
    validateFormat,
    validatePresence,
    validateConfirmation,
    validateLength
} from 'ember-changeset-validations/validators';
import validateDate from './validationRules/validateDate';

export default {
    firstName:      validatePresence(true),
    lastName:       validatePresence(true),
    phoneNumber:    validateFormat({regex: /\+(([0-9]{3})|([0-9]{2}))\s?(([0-9]{3})|([0-9]{2}))\s?[0-9]{3}\s?[0-9]{2}\s?[0-9]{2}/}),
    plainPassword:  validateLength({min: 5}),
    passwordRepeat: validateConfirmation({on: 'plainPassword'}),
    emailRepeat:    validateConfirmation({on: 'email'}),
    email:          validateFormat({ type: 'email' }),
    birthDate:      validateDate({minAge:18}),
    country:        validatePresence(true),
    language:       validatePresence(true),
    title:          validatePresence(true)

};