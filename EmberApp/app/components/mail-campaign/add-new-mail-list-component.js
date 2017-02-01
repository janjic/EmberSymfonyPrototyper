import Ember from 'ember';
import Changeset from 'ember-changeset';
import lookupValidator from './../../utils/lookupValidator';
import MailListValidations from '../../validations/mail-list/mail-list';
import { task, timeout } from 'ember-concurrency';
import LoadingStateMixin from '../../mixins/loading-state';
const {ApiCode, Translator} = window;
export default Ember.Component.extend(LoadingStateMixin, {
    currentUser: Ember.inject.service('current-user'),
    init() {
        this._super(...arguments);
        this.changeset = new Changeset(this.get('model'), lookupValidator(MailListValidations), MailListValidations);
        this.set('additionalMails', []);
    },
    actions: {
        saveMailList(mailList) {
            mailList.validate();
            if(mailList.get('isValid')){
                this.set('model.subscribers', this.get('additionalMails'));
                this.showLoader('loading.sending.data');
                let list = this.get('model');
                list.save().then(() => {
                    this.toast.success(Translator.trans('models.mailList.save'));
                    this.disableLoader();
                    let route = "dashboard.mass-mails.all-mail-lists";
                    if(!this.get('currentUser.isUserAdmin')){
                        route = "dashboard.agent.invite-people.all-mail-lists";
                    }
                    this.get('goToRoute')(route);
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
        agentAdded(value, selectedItems){
            selectedItems = selectedItems.addObject({email: value});
            this.set('additionalMails', selectedItems);
        },
        agentSelected(agent, selectedItems){
            // if(agent.hasOwnProperty('email')){
            //     selectedItems = selectedItems.addObject({email: agent});
            // }else {
            //     selectedItems = selectedItems.addObject({email: agent.get('email')});
            // }
            // this.set('additionalMails', selectedItems);
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
