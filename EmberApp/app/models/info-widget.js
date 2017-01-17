import DS from 'ember-data';

const { attr } = DS;

export default DS.Model.extend({
    today:          attr('number'),
    this_month:     attr('number'),
    total:          attr('number')
});