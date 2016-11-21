import Ember from 'ember';

export default Ember.Component.extend({
    currentUser: Ember.inject.service('current-user'),
    actions: {
        updateAgentBirthDate(date){
            var agent = this.model;
            agent.set('birthDate', date);
        },
        titleChanged(title){
            this.model.set('title', title);
        },
    }
});
