import Ember from 'ember';

export default Ember.Component.extend({
    store: Ember.inject.service(),
    agents: [],
    selectedAgentIndex: -1,
    selectedAgent: null,
    init(){
        this._super(...arguments);
        this.set('agents', this.get('store').findAll('agent'));
        var index = (this.get('agents').indexOf(this.get('selectedAgent')));
        console.log(this.get('selectedAgent'));
        if(index != -1){
            this.set('selectedAgentIndex', index);
        }
    },
    actions: {
        agentChanged: function (agentIndex) {
            var agent = this.get('agents').objectAt(agentIndex);
            this.get('onAgentSelected')(agent);
        }
    }
});
