import {
    validatePresence
} from 'ember-changeset-validations/validators';

const { Translator } = window;

export default {
    participants:   validatePresence({ presence: true, message: Translator.trans('validations.presence-value') }),
    messageSubject: validatePresence({ presence: true, message: Translator.trans('validations.presence-value') }),
    body:           validatePresence({ presence: true, message: Translator.trans('validations.presence-value') }),
};
