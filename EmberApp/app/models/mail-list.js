import DS from 'ember-data';
const { attr } = DS;
const {computed} = Ember;

export default DS.Model.extend({
    name:                attr('string'),
    fromAddress:         attr('string'),
    fromName:            attr('string'),
    permission_reminder: attr('string'),
    subscribers:         attr('array'),
    removedSubscribers:  attr('array'),
    newSubscribers:      attr('array'),
});
