import {
    validatePresence
} from 'ember-changeset-validations/validators';

const { Translator } = window;

export default {
    mailList:   validatePresence({ presence: true, message: Translator.trans('invitation.mail.list.invalid') }),
    // emailContent:   validatePresence({ presence: true, message: Translator.trans('invitation.email.content') })
};