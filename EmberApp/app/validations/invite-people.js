import {
    validatePresence
} from 'ember-changeset-validations/validators';

const { Translator } = window;

export default {
    emailSubject:   validatePresence({ presence: true, message: Translator.trans('invitation.email.subject') }),
    emailContent:   validatePresence({ presence: true, message: Translator.trans('invitation.email.content') })
};