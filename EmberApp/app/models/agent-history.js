import DS from 'ember-data';

const { attr, Model } = DS;

export default Model.extend({

    agent:              DS.belongsTo('agent'),
    changedByAgent:     DS.belongsTo('agent'),
    changedFrom:        DS.belongsTo('group'),
    changedTo:          DS.belongsTo('group'),
    changedToSuspended: attr('boolean'),
    changedType:        attr('string'),
    date:               attr('custom-date')

});