import DS from 'ember-data';
const { attr } = DS;

export default DS.Model.extend({
    created_at:              attr('string'),
    date_from:               attr('string'),
    date_to:                 attr('string'),
    number_of_months:        attr('number'),
    price_per_remaining_day: attr('number'),
    product:                 attr('string'),
    unit_price:              attr('number'),
});
