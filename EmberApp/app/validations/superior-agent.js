import {
    validatePresence,
} from 'ember-changeset-validations/validators';

export default {
    agentID: validatePresence(true),
};