import Ember from 'ember';

export default Ember.Controller.extend({
    store: Ember.inject.service(),
    actions: {
        roleSelected(group){
            this.model.set('group', group);
        },
        titleChanged(title){
            this.model.set('title', title);
        },
        updateAgentBirthDate(date){
            var agent = this.model;
            agent.set('birthDate', date);
        },
        editAgent(agent){
            agent.save().then(() => {
                this.toast.success('Agent saved!');
            }, () => {
                this.toast.error('Data not saved!');
            });
        }
    }
});
