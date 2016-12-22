import DS from 'ember-data';

const { Model, attr } = DS;

export default Model.extend({
    type:            attr('string'),
    createdAt:       attr('string'),
    message:         attr('string')
});