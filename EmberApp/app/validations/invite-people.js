import {
    validateFormat,
    validatePresence
} from 'ember-changeset-validations/validators';

const { Translator } = window;

export default {
    recipientEmail: validateFormat({ regex: /[A-Za-z_0-9.]+@([A-Za-z_0-9]*.[A-Za-z_0-9]*)/ }),
    emailSubject:   validatePresence(true)
};