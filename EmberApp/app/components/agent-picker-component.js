import Ember from 'ember';

export default Ember.Component.extend({
    store: Ember.inject.service(),
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
        this.set('agents', this.get('store').findAll('agent'));
        this.set('selectedAgentId', this.get('selectedAgent.id'));
    },
    actions: {
        agentChanged: function (agentIndex) {
            let agent = this.get('agents').objectAt(agentIndex);
                this.set('changeset.'+this.get('property'), agent);
                this.get('changeset').validate(this.get('property'));
                this.set('changeset.superior', agent);
        }
    }
});
