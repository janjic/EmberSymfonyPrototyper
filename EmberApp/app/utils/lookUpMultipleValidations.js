import Ember from 'ember';
import isPromise from 'ember-changeset/utils/is-promise';

const {
    A: emberArray,
    RSVP: { all },
    get,
    typeOf
} = Ember;

/**
 * Rejects `true` values from an array of validations. Returns `true` when there
 * are no errors, or the error object if there are errors.
 *
 * @private
 * @param  {Array} validations
 * @return {Boolean|Any}
 */
function handleValidations(validations = []) {
    let rejectedValidations = emberArray(validations)
        .reject((validation) => typeOf(validation) === 'boolean' && validation);

    return get(rejectedValidations, 'length') === 0 || rejectedValidations;
}

/**
 *
 * @param validators
 * @param key
 * @param newValue
 * @param oldValue
 * @param changes
 * @param content
 * @returns {*}
 */
export default function handleMultipleValidations(validators, { key, newValue, oldValue, changes, content }) {
    let validations = emberArray(validators
        .map((validator) => {
            let validatorResult =validator(key, newValue, oldValue, changes, content);
            Object.is(validatorResult, true) ? content.set(key, newValue) :false;

            return validatorResult;
        }));

    if (emberArray(validations).any(isPromise)) {
        return all(validations).then(handleValidations);
    }

    return handleValidations(validations);
}