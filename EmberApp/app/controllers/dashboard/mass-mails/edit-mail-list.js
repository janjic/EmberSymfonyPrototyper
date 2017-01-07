import Ember from 'ember';

export default Ember.Controller.extend({
    actions: {
        search (page, text, perPage) {
            return this.get('store').query('agent', {page:page, rows:perPage, search: text, searchField: 'agent.email'}).then(results => results);
        },
        goToRoute(route){
            this.transitionToRoute(route);
        }
    }
});
