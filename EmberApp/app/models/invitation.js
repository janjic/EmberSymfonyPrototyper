import DS from 'ember-data';

const { attr, belongsTo, Model } = DS;

export default Model.extend({
    recipientEmail: attr(),
    emailSubject:   attr('string'),
    emailContent:   attr('string'),
    agent:          belongsTo('agent')
});
