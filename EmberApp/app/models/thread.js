import DS from 'ember-data';

const {  attr, Model } = DS;

export default Model.extend({
    createdBy:      DS.belongsTo('agent'),
    participants:   DS.hasMany('agent'),
    messages:       DS.hasMany('message'),
    createdAt:      attr('custom-date'),
    subject:        attr('string')
});