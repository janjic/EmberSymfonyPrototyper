import Ember from 'ember';
const { service } = Ember.inject;

export default Ember.Controller.extend({
    currentUser: service('current-user'),
    actions: {
        search (page, text, perPage) {
            return this.get('store').query('agent', {page:page, rows:perPage, search: text, searchField: 'agent.email'}).then(results => results);
        },
        createNewThread()
        {
            return this.get('store').createRecord('thread');
        },
        createNewMessage(hash)
        {
            return this.get('store').createRecord('message', hash);
        }
    }
});
