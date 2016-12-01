import {
    validateFormat,
    validatePresence
} from 'ember-changeset-validations/validators';

import validateDate from './validationRules/validateDate';
export default {
    agentId:        validatePresence(true),
    firstName:      validatePresence(true),
    lastName:       validatePresence(true),
    email:          validateFormat({ type: 'email' }),
    privateEmail:   validateFormat({ type: 'email' }),
    birthDate:      validateDate(true),

};