import {
    validatePresence,
} from 'ember-changeset-validations/validators';

export default {
    title:  validatePresence(true),
    text:   validatePresence(true),
};