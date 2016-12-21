import Ember from 'ember';

export default Ember.Controller.extend({
    actions: {
        saveMailListAction(mailList){
            mailList.save();
        },
        search (page, text, perPage) {
            return this.get('store').query('agent', {page:page, rows:perPage, search: text, searchField: 'agent.email'}).then(results => results);
        },
    }
});
