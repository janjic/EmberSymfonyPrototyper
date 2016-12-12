import Ember from 'ember';
import { default as EmpireNestable } from '../../mixins/empire-nestable';
import LoadingStateMixin from '../../mixins/loading-state';
const {ApiCode, Translator} = window;

export default Ember.Component.extend(EmpireNestable, LoadingStateMixin, {
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
                    this.whoIsMyPrev(data);
                });
            });
        });
    },

    actions: {
        addRole() {
            this.showLoader();
            var role = this.get('store').createRecord('role', {name: this.get('newRoleName'), role: this.get('newRoleTitle')});

            role.save().then(() => {
                this.set('newRoleName', '');
                this.set('newRoleTitle', '');
                this.get('items').pushObject(role);
                this.toast.success('models.role.save');
                this.disableLoader();
            }, (response) => {
                role.deleteRecord();
                this.processErrors(response.errors);
                this.disableLoader();
            });
        },

        editRole: function () {
            this.showLoader();
            let item = this.get('currentEditing');
            item.set('simpleUpdate', true);
            item.save().then(() => {
                this.toast.success('models.role.save');
                this.set('currentEditing', null);
                item.set('simpleUpdate', false);
                this.disableLoader();
            }, (response) => {
                item.set('simpleUpdate', false);
                this.get('currentEditing').rollbackAttributes();
                this.processErrors(response.errors);
                this.disableLoader();
            });
        },

        deleteItem(item) {
            this.showLoader();
            item.destroyRecord().then(()=> {
                this.deleteItemFromModel(item);
                this.disableLoader();
                this.toast.success('models.role.delete');
            }, (response)=> {
                this.processErrors(response.errors);
                this.disableLoader();
            });

        },

        setCurrentEditing(item){
            this.set('currentEditing', item);
        },

        serialize() {
            this.set('serializedString', JSON.stringify(this.$('#nestable').nestable('serialize')));
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
                    this.toast.error(Translator.trans('models.role.role-title-unique'));
                    break;
                case ApiCode.ERROR_MESSAGE:
                    this.toast.success(Translator.trans('models.server-error'));
                    break;
                default:
                    return;
            }
        });
    },

    processItemUpdate(item){
        this.showLoader();
        this.toggleProperty('needRefresh');
        item.save().then(()=>{
            this.toggleProperty('needRefresh');
            this.toast.success('models.role.save');
            this.disableLoader();
        }, (response) => {
            this.processErrors(response.errors);
            this.toggleProperty('needRefresh');
            this.disableLoader();
        });
    },
});
