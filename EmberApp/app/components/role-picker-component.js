import Ember from 'ember';

export default Ember.Component.extend({
    store: Ember.inject.service(),
    currentUser: Ember.inject.service('current-user'),
    groups: [],
    selectedGroupIndex: -1,
    selectedGroup: null,
    init(){
        this._super(...arguments);
        console.log(this.get('currentUser.user.group'));
        this.set('groups', this.get('store').findAll('group'));
        let index = (this.get('groups').indexOf(this.get('selectedGroup')));
        if(index !== -1){
            this.set('selectedGroupIndex', index);
        }
    },
    actions: {
        roleChanged: function (groupIndex) {
            var gruop = this.get('groups').objectAt(groupIndex);
            this.set('changeset.'+this.get('property'), gruop);
            this.get('validateProperty')(this.get('changeset'), this.get('property'));
            this.get('onRoleSelected')(gruop);
        }
    }

});
