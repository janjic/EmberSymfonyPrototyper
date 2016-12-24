import {
    validatePresence,
    validateFormat,
} from 'ember-changeset-validations/validators';
const Translator = window.Translator;

export default {
    subject_line: validatePresence(true),
    from_name:    validatePresence(true),
    reply_to:     validatePresence(true),
    template:     validatePresence(true),

};