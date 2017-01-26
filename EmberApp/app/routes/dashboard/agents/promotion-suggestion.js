import Ember from 'ember';
import RSVP from 'rsvp';
const { Routing } = window;

export default Ember.Route.extend({
    authorizedAjax : Ember.inject.service('authorized-ajax'),
    data: null,
    model() {
        return new RSVP.Promise((resolve) =>{
            this.get('authorizedAjax').sendAuthorizedRequest(null, 'GET', Routing.generate('agent-promotion-suggestion'),
                function (response) {
                    resolve(response);
                }.bind(this));
        });
    },
    setupController(controller){
        this._super(...arguments);
        controller.set('groups', this.store.findAll('group'));
    }
});
