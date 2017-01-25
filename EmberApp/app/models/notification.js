import DS from 'ember-data';

const { Model, attr, belongsTo } = DS;

export default Model.extend({
    type:            attr('string'),
    createdAt:       attr('custom-date'),
    isSeen:          attr('boolean'),
    message:         attr('string'),
    link:            attr('string'),
    newAgent:        belongsTo('agent'),
    agent:           belongsTo('agent'),
    payment:         belongsTo('payment-info')
});