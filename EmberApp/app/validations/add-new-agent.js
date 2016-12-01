import {
    validateFormat,
    validatePresence,
    validateConfirmation,
    validateLength
} from 'ember-changeset-validations/validators';
import validateDate from './validationRules/validateDate';


export default {
    agentId:        validatePresence(true),
    firstName:      validatePresence(true),
    lastName:       validatePresence(true),
    email:          validateFormat({ type: 'email' }),
    emailRepeat:    validateConfirmation({on: 'email'}),
    privateEmail:   validateFormat({ type: 'email' }),
    plainPassword:  validateLength({min: 5}),
    passwordRepeat: validateConfirmation({on: 'plainPassword'}),
    superior:       validatePresence(true),
    group:          validatePresence(true),
    birthDate:      validateDate({minAge:18}),
    title:          validatePresence(true),
    nationality:    validatePresence(true)
};
