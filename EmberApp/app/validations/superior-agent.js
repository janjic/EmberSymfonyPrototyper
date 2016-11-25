import {
    validateFormat,
    validatePresence,
    validateConfirmation,
    validateLength
} from 'ember-changeset-validations/validators';

export default {
    agentID: validatePresence(true),
};