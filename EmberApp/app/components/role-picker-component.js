import Ember from 'ember';

export default Ember.Component.extend({
    store: Ember.inject.service(),
    currentUser: Ember.inject.service('current-user'),
    groups: [],
    groupsFiltered: Ember.computed('groups.@each.name', 'currentUser', function () {
        return this.get('groups').filter((item) =>{
            let firstObject = item.get('roles').objectAt(0);
            if (!Object.is(firstObject, undefined)) {
                return !Object.is(this.get('currentUser.user.roles').indexOf(firstObject.get('role')), -1);
            }

            return false;
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
        this.set('selectedGroup', this.get('groups.lastObject'));
    },
    actions: {
        roleChanged: function (groupIndex) {
            let group = this.get('groups').objectAt(groupIndex);
            this.set('changeset.'+this.get('property'), group);
            this.get('validateProperty')(this.get('changeset'), this.get('property'));
            this.get('onRoleSelected')(group);
        },
        chooseDestination(group) {
            this.set('selectedGroup', group);
            // this.calculateRoute();
            // this.updatePrice();
        }
    }

});
