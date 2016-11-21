import {
    validateFormat,
    validatePresence
} from 'ember-changeset-validations/validators';

export default {
    firstName: validatePresence(true),
    lastName: validatePresence(true),
    phoneNumber: validateFormat({regex: /\+(([0-9]{3})|([0-9]{2}))\s?(([0-9]{3})|([0-9]{2}))\s?[0-9]{3}\s?[0-9]{2}\s?[0-9]{2}/}),
};