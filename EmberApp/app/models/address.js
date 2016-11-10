import DS from 'ember-data';

const { attr, Model } = DS;

export default DS.Model.extend({
    streetNumber: attr('string'),
    postcode:     attr('string'),
    city:         attr('string'),
    country:      attr('string'),
    phone:        attr('string'),
    user:         DS.belongsTo('user', {inverse: 'address'})
});