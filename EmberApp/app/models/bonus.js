import DS from 'ember-data';

const { attr, belongsTo, Model } = DS;

export default Model.extend({
    settings:           belongsTo('setting', {inverse: 'bonuses'}, {async: true}),
    group:              belongsTo('group'),
    name:               attr('string'),
    amountCHF:          attr('number'),
    amountEUR:          attr('number'),
    numberOfCustomers:  attr('number'),
    period:             attr('number')
});
