import DS from 'ember-data';
const { attr } = DS;
const {computed} = Ember;

export default DS.Model.extend({
    name:                attr('string'),
    fromAddress:         attr('string'),
    fromName:            attr('string'),
    permission_reminder: attr('string'),
    subscribers:         attr('array'),
    mailCampaign:        DS.belongsTo('mail-campaign', {inverse: 'mailList'}),
    campaign_defaults:   computed('name', 'fromAddress', 'fromName', function () {
        return {
            from_name : this.get('name'),
            from_email: this.get('fromAddress'),
            subject:    this.get('name'),
            language:   'US'
        };
    })

});
