import DS from 'ember-data';

const { Model, attr } = DS;

export default Model.extend({
    sender:          DS.belongsTo('agent'),
    participants:    DS.hasMany('agent'),
    thread:          DS.belongsTo('thread', {inverse:'messages'}),
    body:            attr('string'),
    createdAt:       attr('custom-date'),
});