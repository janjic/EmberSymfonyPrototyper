import {
    validateFormat,
    validatePresence,
    validateConfirmation,
    validateLength
} from 'ember-changeset-validations/validators';
import validateDate from './validationRules/validateDate';

const { Translator } = window;

export default {
    agentId:        validatePresence(true),
    firstName:      validatePresence({ presence: true, message: Translator.trans('validations.presence-value') }),
    lastName:       validatePresence({ presence: true, message: Translator.trans('validations.presence-value') }),
    email:          validateFormat({ type: 'email', message: Translator.trans('validations.presence-email') }),
    privateEmail:   validateFormat({ type: 'email', message: Translator.trans('validations.presence-email') }),
    superior:       validatePresence(true),
    group:          validatePresence(true),
    birthDate:      validateDate({minAge:18, message: Translator.trans('validations.older-than-18')}),
    title:          validatePresence({ presence: true, message: Translator.trans('validations.presence-value') }),
    nationality:    validatePresence(true)
};