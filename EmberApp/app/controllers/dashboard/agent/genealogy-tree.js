import Ember from 'ember';
import {task, timeout} from "ember-concurrency";

export default Ember.Controller.extend({
    actions: {
        redirectToEdit(agentId) {
            this.transitionToRoute('dashboard.agent.agents.agent-view', agentId);
        }
    },
});