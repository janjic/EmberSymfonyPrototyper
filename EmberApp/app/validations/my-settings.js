import {
    validatePresence
} from 'ember-changeset-validations/validators';

export default {
    confirmationMail:   validatePresence(true),
    payPal:             validatePresence(true),
    facebookLink:       validatePresence(true),
    easycall:           validatePresence(true),
    twitterLink:        validatePresence(true),
    gPlusLink:          validatePresence(true),
};