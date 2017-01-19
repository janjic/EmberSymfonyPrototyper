import Ember from 'ember';
import RSVP from 'rsvp';
const { inject: { service }} = Ember;
const { Routing } = window;

export default Ember.Route.extend({
    authorizedAjax: service('authorized-ajax'),

    model: function (params) {
        this.set('agent_id', params.id);
        let agent       = this.store.findRecord('agent', params.id);
        let subAgents   = this.store.query('agent', {
            page: 1,
            offset: 4,
            sidx: 'id',
            sord: 'asc',
            promoCode: params.id
        });

        return RSVP.hash({
            agent,
            subAgents
        });
    },

    setupController: function(controller, model) {
        this._super(...arguments);
        // controller.set('model', model);
        controller.set('maxPages', model.subAgents.meta.pages);
        controller.set('totalItems', model.subAgents.meta.totalItems);
        let agentId = this.get('agent_id');
        controller.set('promoCode', agentId);
        this.get('authorizedAjax').sendAuthorizedRequest(null, 'GET', Routing.generate('agent-info', { id: agentId }),
            function (response) {
                controller.set('info', response.data);
            });
    }
});
