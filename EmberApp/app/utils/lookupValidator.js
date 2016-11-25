import Ember from 'ember';
import wrapInArray from 'ember-changeset-validations/utils/wrap';
import handleMultipleValidations from './lookUpMultipleValidations';
import isPromise from 'ember-changeset/utils/is-promise';

const {
    isEmpty,
    isArray
} = Ember;

export default function lookupValidator(validationMap = {}) {
    return ({ key, newValue, oldValue, changes, content }) => {
        let validator = validationMap[key];
        if (isEmpty(validator)) {
            return true;
        }

        if (isArray(validator)) {
            return handleMultipleValidations(validator, { key, newValue, oldValue, changes, content });
        }

        let validation = validator(key, newValue, oldValue, changes, content);
        if (Object.is(validation, true)) {
            content.set(key, newValue);
        }
        return isPromise(validation) ? validation.then(wrapInArray) : [validation];
    };
}