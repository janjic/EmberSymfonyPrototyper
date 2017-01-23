import {
    validateConfirmation,
    validateLength,
    validatePresence
} from 'ember-changeset-validations/validators';
import AgentValidation from './agent';
import Ember from 'ember';
const { Translator } = window;


const { assign } = Ember;

 const AddAgentValidation = {
     plainPassword:  validateLength({min: 6, message: Translator.trans('validations.presence-password')}),
     passwordRepeat: validateConfirmation({on: 'plainPassword', message: Translator.trans('validations.password-repeat')}),
     superior:       validatePresence(true),
};

export default assign({}, AgentValidation, AddAgentValidation);

