import {
    validatePresence,
} from 'ember-changeset-validations/validators';

export default {
    agentId: validatePresence(true),
};