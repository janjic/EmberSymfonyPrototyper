import {
    validateFormat,
    validatePresence,
    validateConfirmation,
    validateLength
} from 'ember-changeset-validations/validators';

import validateDate from './validationRules/validateDate';
export default {
    agentID:        validatePresence(true),
    firstName:      validatePresence(true),
    lastName:       validatePresence(true),
    email:          validateFormat({ type: 'email' }),
    privateEmail:   validateFormat({ type: 'email' }),
    birthDate:      validateDate(true),

};