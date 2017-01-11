import DS from 'ember-data';
const { attr, belongsTo } = DS;

export default DS.Model.extend({
    agent:              belongsTo('agent'),
    orderId:            attr('string'),

    packagesValue:      attr('number'),
    packagesCommission: attr('number'),

    connectValue:       attr('number'),
    connectPercentage:  attr('number'),
    connectCommission:  attr('number'),

    setupFeeValue:      attr('number'),
    setupFeePercentage: attr('number'),
    setupFeeCommission: attr('number'),

    streamValue:        attr('number'),
    streamPercentage:   attr('number'),
    streamCommission:   attr('number'),

    totalCommission:    attr('number'),

    agentRole:          attr('string'),
    paymentType:        attr('string'),
    memo:               attr('string'),
    createdAt:          attr('custom-date'),
    payedAt:            attr('custom-date'),
});