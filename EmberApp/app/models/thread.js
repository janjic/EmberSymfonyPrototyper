import DS from 'ember-data';

const {  attr, Model } = DS;

export default Model.extend({
    createdBy:      DS.belongsTo('agent'),
    messages:       DS.hasMany('message'),
    threadMetadata: DS.hasMany('thread-metadata'),
    createdAt:      attr('custom-date')

});