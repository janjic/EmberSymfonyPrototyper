import {
    validatePresence
} from 'ember-changeset-validations/validators';

export default {
    amountCHF:              validatePresence(true),
    amountEUR:              validatePresence(true),
    numberOfCustomers:      validatePresence(true),
    period:                 validatePresence(true)
};