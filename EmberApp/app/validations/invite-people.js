import {
    validateFormat,
    validatePresence
} from 'ember-changeset-validations/validators';

const { Translator } = window;

export default {
    // recipientEmail: validateFormat({ regex: /^(?:([A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4})\b[(;\s)|$])+$/i }),
    recipientEmail: validateFormat({ regex: /^([\w\.\-]+\@[\w\.\-]+\.[A-z]{2,10}[,;]?[\s]?)*([,;][\s]*([\w\.\-]+\@[\w\.\-]+\.[A-z]{2,10}))*$/i , allowBlank: false}),
    emailSubject:   validatePresence(true),
    emailContent:   validatePresence(true)
};