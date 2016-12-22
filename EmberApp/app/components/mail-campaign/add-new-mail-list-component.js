import Ember from 'ember';
import Changeset from 'ember-changeset';
import lookupValidator from './../../utils/lookupValidator';
import MailListValidations from '../../validations/mail-list/mail-list';
import { task, timeout } from 'ember-concurrency';
import LoadingStateMixin from '../../mixins/loading-state';
const {ApiCode, Translator} = window;
export default Ember.Component.extend(LoadingStateMixin, {
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
                this.set('model.subscribers', this.get('additionalMails'));
                this.showLoader('loading.sending.data');
                let list = this.get('model');
                list.save().then((response) => {
                    this.toast.success(Translator.trans('models.mailList.save'));
                    this.disableLoader();
                }, (response) => {
                    response.errors.forEach((error)=> {
                        switch (parseInt(error.status)) {
                            case ApiCode.ERROR_MESSAGE:
                                this.toast.error(Translator.trans(error.detail));
                                break;
                            default:
                                return;
                        }
                        this.disableLoader();
                    });
                    this.disableLoader();
                });
            }
        },
        agentSelected(agent){
            if (agent) {
                this.get('additionalMails').addObject({email: agent.get('email')});
            }
        },
        agentAdded(value){
            this.get('additionalMails').addObject({email: value});
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
