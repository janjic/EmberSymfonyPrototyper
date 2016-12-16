import Ember from 'ember';
import buildMessage from 'ember-changeset-validations/utils/validation-errors';

const {
    get,
    isEqual
} = Ember;

export default function validateIsSame(options = {}) {
    let { on } = options;

    return (key, newValue, _oldValue, changes/*, _content*/) => {
        return isEqual(get(changes, on), newValue) ||
            buildMessage(key, 'confirmation', newValue, options);
    };
}