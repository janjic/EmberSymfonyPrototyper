import {
    validateFormat,
    validatePresence,
    validateConfirmation,
    validateLength
} from 'ember-changeset-validations/validators';
import AgentValidation from './agent';
import Ember from 'ember';
const { Translator } = window;


const { assign } = Ember;

export const AddAgentValidation = {
    emailRepeat:    validateConfirmation({on: 'email', message: Translator.trans('validations.email-repeat')}),
    plainPassword:  validateLength({min: 6, message: Translator.trans('validations.presence-password')}),
    passwordRepeat: validateConfirmation({on: 'plainPassword', message: Translator.trans('validations.password-repeat')}),
};

export default assign({}, AgentValidation, AddAgentValidation);

