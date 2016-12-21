import DS from 'ember-data';
const { attr } = DS;

export default DS.Model.extend({
    name:        attr('string'),
    subject:     attr('string'),
    fromEmail:   attr('string'),
    fromName:    attr('string'),
    template:    attr('string'),
    mailList:    DS.belongsTo('mail-list', {inverse: 'mailCampaign'})
});
