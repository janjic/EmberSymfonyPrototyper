import DS from 'ember-data';

const { Model, attr } = DS;

export default Model.extend({
    message:     DS.belongsTo('message', {inverse: 'messageMetadata'}),
    participant: DS.belongsTo('agent'),
    $isRead:     attr('boolean')
});