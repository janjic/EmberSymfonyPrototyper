import DS from 'ember-data';

const { Model } = DS;

export default Model.extend({
    thread:      DS.belongsTo('thread', {inverse: 'threadMetadata'}),
    participant: DS.belongsTo('agent')

});