import {
    validateNumber
} from 'ember-changeset-validations/validators';
const Translator = window.Translator;

export default {
    setupFee:       validateNumber({ number: true, message: Translator.trans('settings.validations.number-validation') }),
    packages:       validateNumber({ number: true, message: Translator.trans('settings.validations.number-validation') }),
    connect:        validateNumber({ number: true, message: Translator.trans('settings.validations.number-validation') }),
    stream:         validateNumber({ number: true, message: Translator.trans('settings.validations.number-validation') })
};