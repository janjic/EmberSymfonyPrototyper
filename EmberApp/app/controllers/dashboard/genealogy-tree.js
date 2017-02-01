import Ember from 'ember';
import {task, timeout} from "ember-concurrency";

export default Ember.Controller.extend({

    queryParams: ['agentId'],
    agentId: null,

    actions: {
        redirectToEdit(agentId) {
            this.transitionToRoute('dashboard.agents.agent-view', agentId);
        }
    },

    search: task(function * (text, page, perPage) {
        yield timeout(200);
        return this.get('store').query('agent', {page:page, rows:perPage, search: text, searchField: 'agent.email'}).then(results => results);
    }),



});