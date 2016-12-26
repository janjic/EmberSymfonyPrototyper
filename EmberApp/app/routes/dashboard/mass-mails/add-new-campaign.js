import Ember from 'ember';

export default Ember.Route.extend({
    model() {
        let campaign = this.store.createRecord('mail-campaign');
        let lists = this.store.findAll('mail-list');
        let templates =this.store.findAll('mail-template');
        return {
            lists,campaign, templates
        };
    }
});
