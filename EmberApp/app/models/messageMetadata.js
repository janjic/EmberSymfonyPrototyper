import Ember from 'ember';
import DS from 'ember-data';

const { attr, Model } = DS;

export default Model.extend({
    message:     DS.belongsTo('message', {inverse: 'messageMetadata'}),
    participant: DS.belongsTo('agent')

});