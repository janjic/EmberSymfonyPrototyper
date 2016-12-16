import Ember from 'ember';
const {assign} = Ember;
export default Ember.Mixin.create({
    actions: {
        addNewImageToAgent (agent, imageObject) {
            let image = this.store.createRecord('image');
            assign(image, imageObject);
            agent.set('image', image);
        },
        goToRoute (route) {
            this.transitionToRoute(route);
        },
        search (page, text, perPage) {
            return this.get('store').query('agent', {page:page, rows:perPage, search: text, searchField: 'agent.email'}).then(results => results);
        },
    }
});
