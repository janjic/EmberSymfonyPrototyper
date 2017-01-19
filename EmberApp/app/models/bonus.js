import DS from 'ember-data';

const { attr, belongsTo, Model } = DS;

export default Model.extend({
    settings:           belongsTo('setting', {inverse: 'bonuses'}, {async: true}),
    group:              belongsTo('group'),
    name:               attr('string'),
    amount:             attr('number'),
    currency:           attr('string'),
    numberOfCustomers:  attr('number'),
    period:             attr('number')
});
