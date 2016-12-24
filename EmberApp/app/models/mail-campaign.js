import DS from 'ember-data';
const { attr } = DS;

export default DS.Model.extend({
    subject_line: attr('string'),
    reply_to:     attr('string'),
    from_name:    attr('string'),
    template:     DS.belongsTo('mail-template'),
    mailList:     DS.belongsTo('mail-list')
});
