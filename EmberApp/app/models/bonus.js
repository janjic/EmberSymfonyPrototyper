import DS from 'ember-data';

const { attr, belongsTo, Model } = DS;

export default Model.extend({
    settings:           belongsTo('setting', {inverse: 'bonuses'}),
    group:              belongsTo('group'),
    amountCHF:          attr('number'),
    amountEUR:          attr('number'),
    numberOfCustomers:  attr('number'),
    period:             attr('number')
});
