import Ember from 'ember';

export default Ember.Component.extend({
    store: Ember.inject.service(),
    agents: [],
    selectedAgentIndex: -1,
    selectedAgentId: null,
    init(){
        this._super(...arguments);
        this.set('agents', this.get('store').findAll('agent'));
        this.set('selectedAgentId', this.get('selectedAgent.id'));
        // let index = (this.get('agents').indexOf(this.get('selectedAgent')));
        // console.log(this.get('selectedAgent.id'));
        // if(index !== -1){
        //     this.set('selectedAgentIndex', index);
        // }
    },
    actions: {
        agentChanged: function (agentIndex) {
            let agent = this.get('agents').objectAt(agentIndex);
            this.set('changeset.'+this.get('property'), agent);
            this.get('validateProperty')(this.get('changeset'), this.get('property'));
            this.get('onAgentSelected')(agent);
        }
    }
});
