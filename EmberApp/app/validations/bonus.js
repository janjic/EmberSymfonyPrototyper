import {
    validateNumber
} from 'ember-changeset-validations/validators';
const Translator = window.Translator;

export default {
    amount:                 validateNumber({ number: true, message: Translator.trans('settings.validations.number-validation') }),
    numberOfCustomers:      validateNumber({ integer: true, message: Translator.trans('settings.validations.integer-validation') }),
    period:                 validateNumber({ integer: true, message: Translator.trans('settings.validations.integer-validation') })
};