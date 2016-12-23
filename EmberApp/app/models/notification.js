import DS from 'ember-data';

const { Model, attr } = DS;

export default Model.extend({
    type:            attr('string'),
    createdAt:       attr('custom-date'),
    isSeen:          attr(),
    message:         attr('string'),
    agent:           DS.belongsTo('agent')
});