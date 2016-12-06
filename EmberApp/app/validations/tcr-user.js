import {
    validateFormat,
    validatePresence
} from 'ember-changeset-validations/validators';
import validateDate from './validationRules/validateDate';

const { Translator } = window;

export default {
    firstName:    validatePresence({ presence: true, message: Translator.trans('validations.presence-value') }),
    lastName:     validatePresence({ presence: true, message: Translator.trans('validations.presence-value') }),
    phoneNumber:  validateFormat({regex: /\+(([0-9]{3})|([0-9]{2}))\s?(([0-9]{3})|([0-9]{2}))\s?[0-9]{3}\s?[0-9]{2}\s?[0-9]{2}/, message: Translator.trans('validations.phone-number')}),
    birthDate:    validateDate({minAge:18, message: Translator.trans('validations.older-than-18')}),
};