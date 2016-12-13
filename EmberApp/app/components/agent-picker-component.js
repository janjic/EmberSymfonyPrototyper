import Ember from 'ember';
import InfinityBlock from "ember-infinity/mixins/route";
import { task, timeout } from 'ember-concurrency';
export default Ember.Component.extend(InfinityBlock, {
    store: Ember.inject.service(),
    results: null,
    meta: null,
    selected: null,
    isLoading: false,
    isLoadingMore: false,
    currentUser: Ember.inject.service('current-user'),
    agents: [],
    selectedAgentIndex: -1,
    selectedAgentId: null,
    agentsFiltered: Ember.computed('agents.[]', 'currentUser', function () {
        if(!Object.is(this.get('currentUser.user.roles').indexOf('ROLE_SUPER_ADMIN'),  -1)){
            return this.get('agents');
        } else {
            return [this.get('currentUser.user')];
        }
    }),

    didInsertElement() {
        this._super(...arguments);
        this.set('selectedAgentId', this.get('selectedAgent.id'));
        this.set('lastId', this.get('agents.lastObject.id'));
        this.set('selected', this.get('agents.firstObject'));
    },
    search: task(function * (text, page) {
        yield timeout(600);
        return this.get('store').query('agent', {page:page, rows:8, search: text, searchField: 'agent.email'}).then(results => results);
    }),
    actions: {
        agentChanged (agent) {
            this.set('model.superior', agent);
        },
        chooseDestination(selectedAgent) {
            this.set('selected', selectedAgent);
        },
    }

});
