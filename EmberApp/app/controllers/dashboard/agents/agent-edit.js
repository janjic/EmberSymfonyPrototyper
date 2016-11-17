import Ember from 'ember';

export default Ember.Controller.extend({
    actions: {
        roleSelected(role){
            this.model.set('role', role);
        },
        titleChanged(title){
            this.model.set('title', title);
        },
        updateAgentBirthDate(date){
            var agent = this.model;
            agent.set('birthDate', date);
        },
    }
});
