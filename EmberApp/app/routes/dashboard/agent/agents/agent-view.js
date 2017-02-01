import Ember from 'ember';
import RSVP from 'rsvp';
const { inject: { service }} = Ember;
const { Routing } = window;

export default Ember.Route.extend({
    authorizedAjax: service('authorized-ajax'),

    model: function (params) {
        this.set('agent_id', params.id);
        let agent       = this.store.findRecord('agent', params.id);

        return RSVP.hash({
            agent,
        });
    },

    actions: {
        error: function(reason) {
            if (reason && reason.errors[0] && reason.errors[0].status === 403) {
                this.toast.error('general.not-allowed');
                this.transitionTo('dashboard.agent.agents.all-agents');
            } else {
                return true; // throw exception
            }
        },
    },


    setupController: function(controller/*, model*/) {
        this._super(...arguments);
        let agentId = this.get('agent_id');
        controller.set('promoCode', agentId);
        controller.set('isSubAgentsLoading', true);
        controller.set('subAgents', []);
        this.get('authorizedAjax').sendAuthorizedRequest(null, 'GET', Routing.generate('agent-info', { id: agentId }),
            function (response) {
                controller.set('info', response.data);
            });
    }
});
