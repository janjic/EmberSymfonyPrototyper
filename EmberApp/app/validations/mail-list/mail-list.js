import {
    validatePresence,
    validateFormat,
} from 'ember-changeset-validations/validators';
const Translator = window.Translator;

export default {
    name:                   validatePresence(true),
    fromName:               validatePresence(true),
    fromAddress:            validateFormat({ type: 'email', message: Translator.trans('validations.presence-email') }),
    permission_reminder:    validatePresence(true),

};