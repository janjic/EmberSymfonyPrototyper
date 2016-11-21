import Ember from 'ember';

export default Ember.Component.extend({
    currentUser: Ember.inject.service('current-user'),
    actions: {
        updateAgentBirthDate(date){
            let agent = this.get('currentUser.user');
            agent.set('birthDate', date);
        },
        titleChanged(title){
            let agent = this.get('currentUser.user');
            agent.set('title', title);
            // this.model.set('title', title);
        },
        editAgent(agent){
            agent.save().then(()=> function () {
                this.toast.success('Profile saved!');
            },() => function () {
                this.toast.error('Profile not saved!');
            })
        }
    }
});
