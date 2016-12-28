import Ember from 'ember';

export default Ember.Route.extend({
    model: function () {
        let agent = this.store.createRecord('agent');
        let address = this.store.createRecord('address');

        this.store.find('agent', 29).then((superAdmin)=>{
            agent.set('superior', superAdmin);
        });

        this.store.queryRecord('group', { group_name: 'Referee' }).then((groupRef)=>{
            agent.set('group', groupRef);
        });

        agent.set('address', address);
        return agent;
    }
});
