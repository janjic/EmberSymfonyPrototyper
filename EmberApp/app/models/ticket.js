import DS from 'ember-data';

const { attr, Model } = DS;

export default Model.extend({
    title:                attr('string'),
    text:                 attr('string'),
    status:               attr('string'),
    type:                 attr('string'),
    createdBy:            DS.belongsTo('agent', {inverse: 'createdTickets'}),
    forwardedTo:          DS.belongsTo('agent', {inverse: 'forwardedTickets'}),
    file:                 DS.belongsTo('file'),
    thread:               DS.belongsTo('thread')

});