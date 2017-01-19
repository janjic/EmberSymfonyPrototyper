import Ember from 'ember';
import RSVP from 'rsvp';
const { Routing } = window;

export default Ember.Route.extend({
    authorizedAjax : Ember.inject.service('authorized-ajax'),
    data: null,
    model() {
        return new RSVP.Promise((resolve) =>{
            this.get('authorizedAjax').sendAuthorizedRequest(null, 'GET', 'app_dev.php'+Routing.generate('agent-promotion-suggestion'),
                function (response) {

                    resolve(response);
                }.bind(this));
        });
    }
});
