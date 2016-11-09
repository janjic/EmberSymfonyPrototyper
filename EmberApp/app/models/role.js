import DS from 'ember-data';

const { attr, Model } = DS;

export default Model.extend({
    name:  attr('string'),
    role:  attr('string'),
    groups: DS.hasMany('group'),
    lft:  attr('integer'),
    lvl:  attr('integer'),
    rgt:  attr('integer'),
    children: DS.hasMany('role', { inverse: 'parent' }),
    parent: DS.belongsTo('role', { inverse: 'children' })
});
