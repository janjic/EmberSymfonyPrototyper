import Ember from 'ember';

export default Ember.Component.extend({
    store: Ember.inject.service(),
    currentUser: Ember.inject.service('current-user'),
    groups: [],
    groupsFiltered: Ember.computed('groups.@each.name', 'currentUser', function () {
        return this.get('groups').filter((item) =>{
            return this.get('currentUser.user.roles').indexOf(item.get('roles').objectAt(0).get('role')) != -1;
        });
    }),
    selectedGroupIndex: -1,
    selectedGroup: null,

    didInsertElement() {
        this._super(...arguments);
        this.set('groups', this.get('store').findAll('group'));
        let index = (this.get('groups').indexOf(this.get('selectedGroup')));
        if(index !== -1){
            this.set('selectedGroupIndex', index);
        }
    },
    actions: {
        roleChanged: function (groupIndex) {
            let group = this.get('groups').objectAt(groupIndex);
            this.set('changeset.'+this.get('property'), group);
            this.get('validateProperty')(this.get('changeset'), this.get('property'));
            this.get('onRoleSelected')(group);
        }
    }

});
