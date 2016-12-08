import Ember from 'ember';
import { default as EmpireNestable } from '../../mixins/empire-nestable';
const {ApiCode, Translator} = window;

export default Ember.Component.extend(EmpireNestable, {
    store: Ember.inject.service('store'),
    items: [],
    getItems: Ember.computed('items.[]', function() {
        return this.get('items');
    }),
    needRefresh: false,

    /** add */
    newRoleName: '',
    newRoleTitle: '',
    addButtonDisabled: Ember.computed('newRoleName', 'newRoleTitle', function() {
        return !(this.get('newRoleName') && this.get('newRoleTitle'));
    }),

    /** edit */
    currentEditing: false,
    editButtonDisabled: Ember.computed('currentEditing', 'currentEditing.name', 'currentEditing.role', function() {
        let item = this.get('currentEditing');
        return item ? (!item.get('name') || !item.get('role')) : true;
    }),

    didInsertElement() {
        this._super(...arguments);
        Ember.run.schedule('afterRender', this,function () {
            this.$('#nestable3').nestable({
                maxDepth:1000
            }).on('change', (e, data)=> {
                Ember.run.next(this, function() {
                    this.whoIsMyPrev(data, e);
                });
            });
        });
    },

    actions: {
        addRole() {
            var role = this.get('store').createRecord('role', {name: this.get('newRoleName'), role: this.get('newRoleTitle')});

            role.save().then(() => {
                this.set('newRoleName', '');
                this.set('newRoleTitle', '');
                this.get('items').pushObject(role);
                this.toast.success('Saved!');
            }, (response) => {
                role.deleteRecord();
                this.processErrors(response.errors);
            });
        },

        editRole: function () {
            let item = this.get('currentEditing');
            item.set('simpleUpdate', true);
            item.save().then(() => {
                this.toast.success('Updated!');
                this.set('currentEditing', null);
                item.set('simpleUpdate', false);
            }, (response) => {
                item.set('simpleUpdate', false);
                this.get('currentEditing').rollbackAttributes();
                this.processErrors(response.errors);
            });
        },

        deleteItem(item) {
            item.destroyRecord().then(()=> {
                this.toast.success('Deleted!');
                this.deleteItemFromModel(item);
            }, (response)=> {
                this.processErrors(response.errors);
            });

        },

        setCurrentEditing(item){
            this.set('currentEditing', item);
        },

        serialize() {
            this.set('serializedString', JSON.stringify(this.$('#nestable').nestable('serialize')));
        },

        updateNested (item) {
            this.findMyPrevAndUpdate(item);
        },

        cancelEdit () {
            this.get('currentEditing').rollbackAttributes();
            this.set('currentEditing', null);
        },
    },

    processErrors(errors) {
        errors.forEach((item) => {
            switch (item.status) {
                case ApiCode.ROLE_ALREADY_EXIST:
                    this.toast.error(Translator.trans('server-response.role-title-unique'));
                    break;
                case ApiCode.ERROR_MESSAGE:
                    this.toast.success(Translator.trans('server-response.server-error'));
                    break;
                default:
                    return;
            }
        });
    }
});
