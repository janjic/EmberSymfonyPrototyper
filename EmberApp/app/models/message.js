import DS from 'ember-data';

const { Model, attr } = DS;

export default Model.extend({
    sender:          DS.belongsTo('agent'),
    thread:          DS.belongsTo('thread', {inverse:'messages'}),
    messageMetadata: DS.hasMany('message-metadata'),
    body:            attr('string'),
    createdAt:       attr('custom-date'),

});