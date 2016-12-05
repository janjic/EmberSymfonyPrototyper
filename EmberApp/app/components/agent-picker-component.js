import Ember from 'ember';

export default Ember.Component.extend({
    store: Ember.inject.service(),
    currentUser: Ember.inject.service('current-user'),
    agents: [],
    selectedAgentIndex: -1,
    selectedAgentId: null,
    agentsFiltered: Ember.computed('agents.@each.name', 'currentUser', function () {
        if(this.get('currentUser.user.roles').indexOf('ROLE_SUPER_ADMIN') !== -1){
            return this.get('agents');
        } else {
            return [this.get('currentUser.user')];
        }
    }),
    init(){
        this._super(...arguments);
        this.set('agents', this.get('store').findAll('agent'));
        this.set('selectedAgentId', this.get('selectedAgent.id'));
        this.get('onAgentSelected')(this.get('selectedAgent'));
    },
    actions: {
        agentChanged: function (agentIndex) {
            let agent = this.get('agents').objectAt(agentIndex);
            if(this.get('isValidated')){
                this.set('changeset.'+this.get('property'), agent);
                this.get('validateProperty')(this.get('changeset'), this.get('property'));
            }
            this.get('onAgentSelected')(agent);
        }
    }
});
