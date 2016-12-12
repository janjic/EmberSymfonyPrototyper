import Ember from 'ember';
import DS from 'ember-data';

const { attr, Model } = DS;

export default Model.extend({
    thread:      DS.belongsTo('thread', {inverse: 'threadMetadata'}),
    participant: DS.belongsTo('agent')

});