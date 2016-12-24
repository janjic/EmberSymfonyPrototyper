import Ember from 'ember';

export default Ember.Route.extend({
    model(params) {
       let campaign = this.store.findRecord('mail-campaign', params.id);
        let lists = this.store.findAll('mail-list');
        let templates =this.store.findAll('mail-template');

        return Ember.RSVP.hash({
            lists,campaign, templates
        });
    }
});
