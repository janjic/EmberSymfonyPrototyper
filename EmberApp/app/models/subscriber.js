import DS from 'ember-data';
const { attr } = DS;
const {computed} = Ember;

export default DS.Model.extend({
    email:            attr('string'),
    mailLists:        DS.hasMany('mail-list', {inverse: 'subscribers'}),
});
