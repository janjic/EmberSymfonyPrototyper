import DS from 'ember-data';

const { attr } = DS;

export default DS.Model.extend({
    streetNumber: attr('string'),
    postcode:     attr('string'),
    city:         attr('string'),
    country:      attr('string'),
    phone:        attr('string'),
    fixedPhone:   attr('string'),
    agent:        DS.belongsTo('agent', {inverse: 'address'})
});
