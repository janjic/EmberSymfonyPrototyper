import Ember from 'ember';
import { task, timeout } from 'ember-concurrency';
import LoadingStateMixin from '../../mixins/loading-state';
import Changeset from 'ember-changeset';
import lookupValidator from './../../utils/lookupValidator';
import MailCampaignValidations from '../../validations/mail-list/mail-campaign';
const {ApiCode, Translator} = window;

export default Ember.Component.extend(LoadingStateMixin, {
    init() {
        this._super(...arguments);
        this.changeset = new Changeset(this.get('model'), lookupValidator(MailCampaignValidations), MailCampaignValidations);
    },
    actions: {
        changeList(list){
            this.set('changeset.mailList', list);
            this.get('changeset').validate('mailList');
        },
        changeTemplate(template){
            this.set('changeset.template', template);
            this.get('changeset').validate('template');
        },
        save(){
            if (this.get('changeset').validate() && this.get('changeset').get('isValid')) {
                this.showLoader();
                let campaign = this.get('changeset');
                campaign.save().then(() => {
                    this.toast.success('models.message.save');
                    this.disableLoader();
                    // this.get('transitionToInbox')();
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
                });
            }
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
