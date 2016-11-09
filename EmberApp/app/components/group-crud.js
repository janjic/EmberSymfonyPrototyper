import Ember from 'ember';

export default Ember.Component.extend({
    groups: [],
    addName: '',
    store: Ember.inject.service(),

    /** add */
    displayAdd: Ember.computed('displayEdit', 'displayDelete', function() {
        return this.get('displayEdit') === false && this.get('displayDelete') === false ;
    }),

    /** edit */
    editGroup: null,
    displayEdit: Ember.computed('editGroup', function() {
        return this.get('editGroup') !== null;
    }),

    /** delete */
    itemToDelete: null,
    newGroupForUsers: null,
    displayDelete: Ember.computed('itemToDelete', function() {
        return this.get('itemToDelete') !== null;
    }),
    isDeleteButtonDisabled: Ember.computed('itemToDelete', 'newGroupForUsers', function() {
        var emptyAll = this.get('itemToDelete') != null && this.get('newGroupForUsers') != null;
        return !emptyAll;
    }),
    availableParents: Ember.computed('itemToDelete', function() {
        var _this = this;
        return this.get('groups').filter(function(item){
            return item !== _this.get('itemToDelete');
        });
    }),

    actions: {
        createGroup: function() {
            var _this = this;
            var group = this.get('store').createRecord('group', {name: this.get('addName')});

            group.save().then(function() {
                _this.set('name', '');
            }, function () {
                group.deleteRecord();
            });
        },

        deleteGroupActionStart: function (group) {
            this.set('itemToDelete', group);
        },

        setNewParentGroup: function (group) {
            this.set('newGroupForUsers', group);
        },

        deleteGroup: function () {
            var _this = this;
            var group = this.get('itemToDelete');
            group.set('newParent', this.get('newGroupForUsers'));
            group.deleteRecord();
            group.save().then(function () {
                _this.set('itemToDelete', null);
                _this.set('newGroupForUsers', null);
            }, function () {
                group.rollbackAttributes();
            });
        },

        /** edit group */
        editGroupAction: function (group) {
            this.set('editGroup', group);
        },

        editGroupSave: function () {
            this.get('editGroup').save().then(function () {

            }, function () {
            });
        },

        returnToAdd: function() {
            this.set('itemToDelete', null);
            this.set('newGroupForUsers', null);

            this.set('editGroup', null);
        }
    }
});
