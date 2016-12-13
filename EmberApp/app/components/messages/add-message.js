import Ember from 'ember';
import { task, timeout } from 'ember-concurrency';
import LoadingStateMixin from '../../mixins/loading-state';

const {ApiCode, Translator} = window;
const { inject: { service }} = Ember;

export default Ember.Component.extend(LoadingStateMixin, {
    authorizedAjax: service('authorized-ajax'),
    currentUser: Ember.inject.service('current-user'),
    store: service('store'),
    participant: null,
    searchTask: task(function* (term) {
        yield timeout(1500);

        let options = {
            field: 'agent.email',
            search: term,
            page: 1,
            rows: 10
        };

        this.get('authorizedAjax').sendAuthorizedRequest(options, 'GET', 'app_dev.php/api/agents', function (response) {
            console.log(response);
        }.bind(this), this);

    }),

    actions: {
        sendMessage() {

            this.showLoader();

            var agentPromise = this.get('store').findRecord('agent', 30);

            Ember.RSVP.allSettled([agentPromise]).then(([pPromise]) => {
                let reciver = pPromise.value;

                let message = this.get('store').createRecord('message', {
                    sender:          this.get('currentUser.user'),
                    participants:    [reciver],
                    body:            this.get('body'),
                    messageSubject:  this.get('subject'),
                });

                message.save().then(() => {
                    this.toast.success('models.message.save');
                    this.disableLoader();
                }, (response) => {
                    this.processErrors(response.errors);
                    this.disableLoader();
                });
            });
        }
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