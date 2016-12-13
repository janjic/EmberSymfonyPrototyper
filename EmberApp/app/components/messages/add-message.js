import Ember from 'ember';
import { task, timeout } from 'ember-concurrency';
import LoadingStateMixin from '../../mixins/loading-state';
import MessageValidations from '../../validations/message-new';
import Changeset from 'ember-changeset';
import lookupValidator from './../../utils/lookupValidator';

const {ApiCode, Translator} = window;
const { inject: { service }} = Ember;

export default Ember.Component.extend(LoadingStateMixin, {
    MessageValidations,
    store: service('store'),
    currentUser: Ember.inject.service('current-user'),

    search: task(function * (text, page, perPage) {
        yield timeout(200);
        return this.get('searchQuery')(page, text, perPage);
    }),

    init() {
        this._super(...arguments);
        this.changeset = new Changeset(this.get('model'), lookupValidator(MessageValidations), MessageValidations);
    },

    actions: {
        sendMessage() {
            let changeSet = this.get('changeset');
            if (changeSet.validate() && changeSet.get('isValid')) {
                this.showLoader();

                let message = this.get('model');
                message.set('sender', this.get('currentUser.user'));
                message.save().then(() => {
                    this.toast.success('models.message.save');
                    this.disableLoader();
                }, (response) => {
                    this.processErrors(response.errors);
                    this.disableLoader();
                });
            }
        },

        agentSelected(agent){
            this.set('changeset.participants', agent ? [agent] : null);
            this.get('changeset').validate('sender');
        },

        /** validations */
        reset(changeset) {
            return changeset.rollback();
        },
        validateProperty(changeset, property) {
            return changeset.validate(property);
        },
    },

    processErrors(errors) {
        errors.forEach((item) => {
            switch (item.status) {
                case ApiCode.ERROR_MESSAGE:
                    this.toast.success(Translator.trans('models.server-error'));
                    break;
                default:
                    return;
            }
        });
    },
});