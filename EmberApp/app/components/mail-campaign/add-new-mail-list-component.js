import Ember from 'ember';
import Changeset from 'ember-changeset';
import lookupValidator from './../../utils/lookupValidator';
import MailListValidations from '../../validations/mail-list/mail-list';
import { task, timeout } from 'ember-concurrency';

export default Ember.Component.extend({
    additionalMails : [],
    items : [],
    init() {
        this._super(...arguments);
        this.changeset = new Changeset(this.get('model'), lookupValidator(MailListValidations), MailListValidations);
    },
    actions: {
        saveMailList(mailList) {
            mailList.validate();
            if(mailList.get('isValid')){
                this.set('model.subscribers', this.get('items'));
                this.get('saveMailListAction')(this.get('model'));
            }
        },
        agentSelected(agent){
            // this.get('additionalMails').addObject({email: agent.get('email')});
            this.get('items').addObject({email: agent.get('email')});
        },
        agentAdded(value){
            this.get('additionalMails').addObject({email: value});
            this.get('items').addObject({email: value});
        },
        validateProperty(changeset, property) {
            return changeset.validate(property);
        },
    },
    search: task(function * (text, page, perPage) {
        yield timeout(200);
        return this.get('searchQuery')(page, text, perPage);
    }),
});
