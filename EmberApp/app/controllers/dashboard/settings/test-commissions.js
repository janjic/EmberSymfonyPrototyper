import Ember from "ember";
import {task, timeout} from "ember-concurrency";
const {Routing} = window;


export default Ember.Controller.extend({
    authorizedAjax: Ember.inject.service('authorized-ajax'),

    agent: null,
    sumPackages: 0,
    sumConnection: 0,
    sumOneTimeSetupFee: 0,
    sumStreams: 0,

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
            let options = {
                sumPackages: this.get('sumPackages'),
                sumConnection: this.get('sumConnection'),
                sumOneTimeSetupFee: this.get('sumOneTimeSetupFee'),
                sumStreams: this.get('sumStreams'),
                agentId: this.get('agent.id'),
            };

            this.get('authorizedAjax').sendAuthorizedRequest(options, 'POST', 'app_dev.php'+Routing.generate('test_payment'),
                function (response) {
                    console.log(response);
                    this.set('serverResponse', response.data);
                }.bind(this), this);
        }
    }
});