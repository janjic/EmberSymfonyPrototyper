import DS from 'ember-data';

const { Model } = DS;

export default Model.extend({
    name:  DS.attr(),
    role:  DS.attr(),
    groups: DS.hasMany('group'),
    // lft:  DS.attr(),
    lvl:  DS.attr(),
    // rgt:  DS.attr(),
    // root:  DS.attr(),
    children: DS.hasMany('role', { inverse: 'parent' }),
    parent: DS.belongsTo('role', { inverse: 'children' }),
    prev: DS.attr(), // used only for sending data to sever
    simpleUpdate: DS.attr('boolean', { defaultValue: false }), // used only for sending data to sever
});
