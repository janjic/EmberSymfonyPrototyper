import {
    validatePresence,
} from 'ember-changeset-validations/validators';

export default {
    subject_line: validatePresence(true),
    from_name:    validatePresence(true),
    reply_to:     validatePresence(true),
    template:     validatePresence(true),
    mailList:     validatePresence(true),

};