import DS from 'ember-data';

const { attr, Model } = DS;

export default Model.extend({
    name:  attr('string'),
    // roles:  DS.hasMany('role')
});
