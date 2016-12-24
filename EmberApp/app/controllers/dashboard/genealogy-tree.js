import Ember from 'ember';

export default Ember.Controller.extend({
    actions: {
        redirectToEdit(agentId) {
            this.transitionToRoute('dashboard.agents.agent-edit', agentId);
        }
    }
});