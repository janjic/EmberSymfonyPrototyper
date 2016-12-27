import {
    validateFormat,
    validatePresence,
    validateConfirmation,
    validateLength
} from 'ember-changeset-validations/validators';
import validateDate from './validationRules/validateDate';

const { Translator } = window;

export default {
    firstName:      validatePresence({ presence: true, message: Translator.trans('validations.presence-value') }),
    lastName:       validatePresence({ presence: true, message: Translator.trans('validations.presence-value') }),
    phoneNumber:    validateFormat({regex: /\+(([0-9]{3})|([0-9]{2}))\s?(([0-9]{3})|([0-9]{2}))\s?[0-9]{3}\s?[0-9]{2}\s?[0-9]{2}/, message: Translator.trans('validations.phone-number')}),
    plainPassword:  validateLength({min: 5, message: Translator.trans('validations.presence-password')}),
    passwordRepeat: validateConfirmation({on: 'plainPassword', message: Translator.trans('validations.password-repeat')}),
    emailRepeat:    validateConfirmation({on: 'email', message: Translator.trans('validations.email-repeat')}),
    email:          validateFormat({ type: 'email', message: Translator.trans('validations.presence-email') }),
    birthDate:      validateDate({minAge:18, message: Translator.trans('validations.older-than-18')}),
    country:        validatePresence({ presence: true, message: Translator.trans('validations.presence-value') }),
    language:       validatePresence({ presence: true, message: Translator.trans('validations.presence-value') }),
    title:          validatePresence({ presence: true, message: Translator.trans('validations.presence-value') }),
    agent:          validatePresence(true)
};