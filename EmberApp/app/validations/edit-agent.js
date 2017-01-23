
import AgentValidation from './agent';
import Ember from 'ember';
const { Translator } = window;
import validateIsSame  from '../validators/same';
import {
    validatePresence,
    validateFormat
} from 'ember-changeset-validations/validators';
const { assign } = Ember;
const EditAgentValidation = {
    plainPassword:  validateFormat({regex: /^($|.{6,})$/,      message: Translator.trans('validations.presence-password')}),
    passwordRepeat: validateIsSame({on: 'plainPassword', message: Translator.trans('validations.password-repeat')}),
    superior:       validatePresence(true),
};
export default assign({},AgentValidation, EditAgentValidation);

