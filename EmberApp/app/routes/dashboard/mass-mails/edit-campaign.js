import Ember from 'ember';

export default Ember.Route.extend({
    model(params) {
       let campaign = this.store.createRecord('mail-campaign');
        let lists = this.store.findAll('mail-list');
        let templates =this.store.findAll('mail-template');
        let oldCampaign = this.store.findRecord('mail-campaign', params.id, {reload: true});

        return Ember.RSVP.hash({
            lists,campaign, templates, oldCampaign
        });
    }
});
