import Ember from 'ember';

const { service } = Ember.inject;

export default Ember.Route.extend({
    currentUser: service('current-user'),

    model: function () {
        let agent = this.store.createRecord('agent');
        let address = this.store.createRecord('address');

        this.store.queryRecord('group', { group_name: 'Referee' }).then((groupRef)=>{
            agent.set('group', groupRef);
        });

        agent.set('superior', this.get('currentUser.user'));
        agent.set('address', address);
        return agent;
    }
});
