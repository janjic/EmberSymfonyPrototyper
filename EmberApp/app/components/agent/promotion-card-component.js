import Ember from 'ember';
import RSVP from 'rsvp';
import { task, timeout } from 'ember-concurrency';
const { Routing } = window;

export default Ember.Component.extend({
    authorizedAjax      : Ember.inject.service('authorized-ajax'),
    isModalOpen         : false,
    isSuperiorModalOpen : false,
    currentAgent        : null,
    currentSuperior     : null,
    currentSuperiorRole : null,
    actions:{
        promote(agent){
            this.set('currentAgent', agent);
            if(agent.role_code === this.get('role_codes').role_referee){
                this.set('isModalOpen', true);
                this.set('currentSuperior', null);
            } else {
                let data = {
                    agent_id : this.get('currentAgent').agent_id,
                    action   : "promote"
                };
                this.sendRequest(data);
            }
        },
        doPromotion(){
            let data = {
                agent_id : this.get('currentAgent').agent_id,
                superior : parseInt(this.get('currentSuperior.id')),
                action   : "promote"
            };

            this.sendRequest(data);
        },
        demote(agent){
            this.set('currentAgent', agent);
            if(agent.role_code === this.get('role_codes').role_active_agent){
                this.set('isSuperiorModalOpen', true);
                this.set('currentSuperiorRole', null);
            } else {
                let data = {
                    agent_id : this.get('currentAgent').agent_id,
                    action   : "demote"
                };
                this.sendRequest(data);
            }
        },
        agentSelected(agent){
            this.set('currentSuperior', agent);
            console.log(agent);
        },
    },
    search: task(function * (text, page, perPage) {
        yield timeout(200);
        return this.get('searchQuery')(page, text, perPage);
    }),

    sendRequest(data){
        return new RSVP.Promise((resolve) => {
            this.get('authorizedAjax').sendAuthorizedRequest(data, 'POST', 'app_dev.php'+Routing.generate('promote-agent'),
                function (response) {
                    console.log(response);
                    // resolve(response);
                    // this.set('serverResponse', response.data);
                });
        });
    }
});
