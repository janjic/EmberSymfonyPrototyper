import Ember from 'ember';
import LoadingStateMixin from '../mixins/loading-state';
const {ApiCode, Translator} = window;

export default Ember.Component.extend(LoadingStateMixin, {
    groups: [],
    store: Ember.inject.service(),

    selectedRolesList: [],

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
        createGroup() {
            var group = this.get('store').createRecord('group', {name: this.get('addName')});
            group.set('roles', this.get('selectedRolesList'));
            this.showLoader();
            group.save().then(() => {
                this.toast.success('models.group.save');
                this.set('addName', '');
                this.disableLoader();
            }, (response) => {
                group.deleteRecord();
                this.disableLoader();
                this.processErrors(response.errors);
            });
        },

        /** delete group */
        deleteGroupActionStart(group) {
            this.set('itemToDelete', group);
            this.set('editGroup', null);
        },

        setNewParentGroup(group) {
            this.set('newGroupForUsers', group);
        },

        deleteGroup() {
            var group = this.get('itemToDelete');
            group.set('newParent', this.get('newGroupForUsers'));
            this.showLoader();
            group.destroyRecord().then(() => {
                this.set('itemToDelete', null);
                this.set('newGroupForUsers', null);
                this.toast.success('models.group.delete');
                this.disableLoader();
            }, (response) => {
                group.rollbackAttributes();
                this.processErrors(response.errors);
                this.disableLoader();
            });
        },

        /** edit group */
        editGroupAction(group) {
            if (this.get('editGroup')) {
                this.get('editGroup').rollbackAttributes();
            }
            this.set('itemToDelete', null);
            this.set('editGroup', group);
            this.set('selectedRolesList', group.get('roles'));
        },

        editGroupSave() {
            let editGroup = this.get('editGroup');
            editGroup.set('roles', this.get('selectedRolesList'));
            this.showLoader();
            editGroup.save().then(() => {
                this.toast.success('models.group.save');
                this.disableLoader();
            }, (response) => {
                this.processErrors(response.errors);
                this.disableLoader();
            });
        },

        cancelEdit() {
            this.get('editGroup').rollbackAttributes();
            this.set('editGroup', null);
        },

        cancelDelete() {
            this.set('itemToDelete', null);
            this.set('newGroupForUsers', null);
        },

        roleSelect(value) {
            this.set('selectedRolesList', value);
        }
    },

    processErrors(errors) {
        errors.forEach((item) => {
            switch (item.status) {
                case ApiCode.GROUP_ALREADY_EXIST:
                    this.toast.error(Translator.trans('models.group.group-name-unique'));
                    break;
                case ApiCode.GROUP_CHANGE_FOR_USERS_FAILED:
                case ApiCode.ERROR_MESSAGE:
                    this.toast.success(Translator.trans('models.server-error'));
                    break;
                default:
                    return;
            }
        });
    }
});
