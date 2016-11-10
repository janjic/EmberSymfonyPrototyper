import Ember from 'ember';

export default Ember.Component.extend({
    groups: [],
    store: Ember.inject.service(),

    /** add */
    addName: '',

    /** edit */
    editGroup: null,
    displayEdit: Ember.computed('editGroup', 'itemToDelete', function() {
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
        return this.get('groups').filter((item) => {
            return item !== this.get('itemToDelete');
        });
    }),

    actions: {
        createGroup: function() {
            var group = this.get('store').createRecord('group', {name: this.get('addName'), type: 'group'});

            group.save().then(() => {
                this.set('addName', '');
            }, () => {
                group.deleteRecord();
            });
        },

        /** delete group */
        deleteGroupActionStart: function (group) {
            this.set('itemToDelete', group);
            this.set('editGroup', null);
        },

        setNewParentGroup: function (group) {
            this.set('newGroupForUsers', group);
        },

        deleteGroup: function () {
            var group = this.get('itemToDelete');
            group.set('newParent', this.get('newGroupForUsers'));
            group.destroyRecord().then(() => {
                this.set('itemToDelete', null);
                this.set('newGroupForUsers', null);
                this.get('groups').removeAt(this.get('groups').indexOf(group));
            }, () => {
                group.rollbackAttributes();
            });
        },

        /** edit group */
        editGroupAction: function (group) {
            this.set('itemToDelete', null);
            this.set('editGroup', group);
        },

        editGroupSave: function () {
            this.get('editGroup').save().then(function () {

            }, function () {
            });
        },

        cancelEdit: function() {
            this.get('editGroup').rollbackAttributes();
            this.set('editGroup', null);
        },

        cancelDelete: function() {
            this.set('itemToDelete', null);
            this.set('newGroupForUsers', null);
        },

    }
});
