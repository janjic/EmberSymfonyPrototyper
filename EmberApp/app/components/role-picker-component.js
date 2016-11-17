import Ember from 'ember';

export default Ember.Component.extend({
    store: Ember.inject.service(),
    groups: [],

    init(){
        this._super(...arguments);
        this.set('groups', this.get('store').findAll('group'));
    },
    actions: {
        roleChanged: function (groupIndex) {
            var gruop = this.get('groups').objectAt(groupIndex);
            this.get('onRoleSelected')(gruop);
        }
    }

});
