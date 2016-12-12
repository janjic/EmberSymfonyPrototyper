import DS from 'ember-data';

const { Model } = DS;

export default Model.extend({
    sender:          DS.belongsTo('agent'),
    thread:          DS.belongsTo('thread', {inverse:'messages'}),
    messageMetadata: DS.hasMany('messageMetadata')

});