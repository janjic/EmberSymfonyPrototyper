import DS from 'ember-data';

const { attr, Model } = DS;
const {computed} = Ember;

export default Model.extend({
    title:                attr('string'),
    text:                 attr('string'),
    status:               attr('string'),
    type:                 attr('string'),
    createdAt:            attr('custom-date'),
    createdAtReadable: computed('createdAt', function() {
        let date = new Date(this.get('createdAt'));
        return  date.getDate() + '/' + (date.getMonth() + 1) + '/' +  date.getFullYear();
    }),
    createdBy:            DS.belongsTo('agent', {inverse: 'createdTickets'}),
    forwardedTo:          DS.belongsTo('agent', {inverse: 'forwardedTickets'}),
    file:                 DS.belongsTo('file'),
    thread:               DS.belongsTo('thread')

});