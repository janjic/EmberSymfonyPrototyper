import Ember from 'ember';

export default Ember.Controller.extend({
    actions: {
        search (page, text, perPage) {
            return this.get('store').query('agent', {page:page, rows:perPage, search: text, searchField: 'agent.email'}).then(results => results);
        },

        createFile(hash) {
            return this.get('store').createRecord('file', hash);
        },

        transitionToInbox() {
            this.transitionToRoute('dashboard.agent.messages.sent');
        }
    }
});