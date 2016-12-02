import Ember from 'ember';
import buildMessage from 'ember-changeset-validations/utils/validation-errors';

const {
    get,
    isPresent,
    isBlank
} = Ember;

function _testDate(key, value, valid, context = {}) {
    return valid? true: buildMessage(key, 'present', value, context);
}

export default function validateDate(opts) {
    return (key, value) => {
        if(value){
            let today = new Date();
            let year = today.getFullYear()-18;
            let month = today.getMonth();
            let day = today.getDate();
            let valid = (new Date(value) < new Date(year, month, day));
            return _testDate(key, value, valid, opts);
        }
        else {
            return buildMessage(key, 'present', value, opts)
        }
    };
}