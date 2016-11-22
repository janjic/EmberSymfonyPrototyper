import Ember from 'ember';

export default Ember.Component.extend({
    store: Ember.inject.service(),
    groups: [],
    selectedGroupIndex: -1,
    selectedGroup: null,
    init(){
        this._super(...arguments);
        this.set('groups', this.get('store').findAll('group'));
        var index = (this.get('groups').indexOf(this.get('selectedGroup')));
        if(index != -1){
            this.set('selectedGroupIndex', index);
        }
    },
    actions: {
        roleChanged: function (groupIndex) {
            var gruop = this.get('groups').objectAt(groupIndex);
            this.get('onRoleSelected')(gruop);
        }
    }

});
