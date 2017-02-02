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
        let ctx = this;
        this.get('model.subscribers').forEach(function (element, index) {
            ctx.get('model.subscribers')[index] = {email: element};
        });
        this.set('additionalMails', this.get('model.subscribers'));
        this.set('model.newSubscribers', []);
        this.set('model.removedSubscribers', []);
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
                    // this.get('goToRoute')('dashboard.mass-mails.all-mail-lists');
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
            this.get('model.newSubscribers').pushObject({email:value});
        },
        agentSelected(agent){
            let newSubsIndex = this.itemInArray(this.get('model.newSubscribers'), agent);
            if(newSubsIndex === -1) {
                if(agent.hasOwnProperty('email')){
                    this.get('model.newSubscribers').pushObject({email:agent.email});
                }else {
                    this.get('model.newSubscribers').pushObject({email: agent.get('email')});
                }
            }

        },
        agentRemoved(agent){
            let newSubsIndex = this.itemInArray(this.get('model.newSubscribers'), agent);
            if( newSubsIndex === -1){
                if(this.itemInArray(this.get('model.removedSubscribers'), agent)===-1){
                    this.get('model.removedSubscribers').pushObject({email:agent.email});
                }
            } else {
                this.get('model.newSubscribers').removeAt(newSubsIndex);
            }
        },
        validateProperty(changeset, property) {
            return changeset.validate(property);
        },
    },

    /**
     *
     * @param array
     * @param item
     * @returns {number}
     */
    itemInArray(array, item){
        let elIndex = -1;
        array.forEach(function (element, index) {
            if(item.hasOwnProperty('email')){
                if (element.email === item.email){
                    elIndex = index;
                }
            } else {
                if (element.email === item.get('email')){
                    elIndex = index;
                }
            }

        });

        return elIndex;
    },
    search: task(function * (text, page, perPage) {
        yield timeout(200);
        return this.get('searchQuery')(page, text, perPage);
    }),
});
