import Ember from "ember";
import {task, timeout} from "ember-concurrency";
const {Routing} = window;


export default Ember.Controller.extend({
    authorizedAjax: Ember.inject.service('authorized-ajax'),

    agent: null,
    orderId: 2,
    customerId: 2,
    sumPackages: 100,
    sumConnection: 100,
    sumOneTimeSetupFee: 100,
    sumStreams: 100,
    currency: 'EUR',

    serverResponse: [],


    search: task(function * (text, page, perPage) {
        yield timeout(200);
        return this.get('store').query('agent', {page:page, rows:perPage, search: text, searchField: 'agent.email'}).then(results => results);
    }),

    actions: {
        agentSelected(agent){
            this.set('agent', agent);
        },

        sendAjax() {
            if (!this.get('sumPackages') || !this.get('sumConnection') || !this.get('sumOneTimeSetupFee') || !this.get('sumStreams') ||
                !this.get('agent') || !this.get('orderId') || !this.get('customerId') || !this.get('currency')) {
                this.toast.error('Please fill out all of the fields');
                return;
            }

            let options = {
                sumPackages: this.get('sumPackages'),
                sumConnection: this.get('sumConnection'),
                sumOneTimeSetupFee: this.get('sumOneTimeSetupFee'),
                sumStreams: this.get('sumStreams'),
                agentId: this.get('agent.id'),
                orderId: this.get('orderId'),
                customerId: this.get('customerId'),
                currency: this.get('currency')
            };

            this.get('authorizedAjax').sendAuthorizedRequest(options, 'POST', 'app_dev.php'+Routing.generate('test_payment'), function (response) {
                this.set('serverResponse', response.data);
            }.bind(this), this);
        }
    }
});