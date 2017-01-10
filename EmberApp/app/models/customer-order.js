import DS from 'ember-data';
const { attr } = DS;

export default DS.Model.extend({
    name:                    attr('string'),
    surname:                 attr('string'),
    total:                   attr('string'),
    created_at:              attr('string'),
    completed_at:            attr('string'),
    connect_price:           attr('string'),
    connect_price_per_month: attr('string'),
    fee_price:               attr('number'),
    items_total:             attr('number'),
    largest_period:          attr('number'),
    num_of_remaining_days:   attr('number'),
    num_of_streams:          attr('number'),
    package_names:           attr('string'),
    price_per_remaining_day: attr('number'),
    state:                   attr('string'),
    stream_date_to:          attr('string'),
    stream_price:            attr('number'),
    stream_price_per_month:  attr('number'),
    streams_length:          attr('number'),
    description:             attr(),
    user_avatar:             attr('string'),
    user:                    DS.belongsTo('tcr-user'),
    items:                   DS.hasMany('order-item'),
});
