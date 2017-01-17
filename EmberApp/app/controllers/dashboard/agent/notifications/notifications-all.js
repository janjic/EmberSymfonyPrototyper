import Ember from 'ember';

export default Ember.Controller.extend({
    currentUser: Ember.inject.service('current-user'),

    init(){
        this._super(...arguments);
        let agent_id = this.get('currentUser.user.agentId');
        this.store.query('tcr-user', {
            page: 1,
            offset: 9,
            sidx: 'id',
            sord: 'asc',
            agentId: agent_id
        }).then((users)=>{
            this.set('allUsers', users);
        });
    }
});