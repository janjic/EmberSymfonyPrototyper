import {
    validatePresence
} from 'ember-changeset-validations/validators';

export default {
    setupFee:       validatePresence(true),
    packages:       validatePresence(true),
    connect:        validatePresence(true),
    stream:         validatePresence(true)
};