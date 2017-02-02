import Ember from 'ember';
import TCRUserValidations from '../../validations/tcr-user-add';
import Changeset from 'ember-changeset';
import lookupValidator from './../../utils/lookupValidator';
import { task, timeout } from 'ember-concurrency';

const { Translator } = window;

export default Ember.Component.extend({
    TCRUserValidations,
    store: Ember.inject.service('store'),
    routing: Ember.inject.service('-routing'),
    current_user: Ember.inject.service('current-user'),

    isUserAdmin: Ember.computed('current_user.user', function() {
        return this.get('current_user.user').get('roles').includes('ROLE_SUPER_ADMIN');
    }),

    search: task(function * (text, page, perPage) {
        yield timeout(200);
        return this.searchQuery(page, text, perPage);
    }),

    userCity: '',
    userStreet: '',
    address: Ember.computed('userCity', 'userStreet', function() {
        this.set('changeset.address', this.get('userCity')+', '+this.get('userStreet'));
    }),
    init() {
        this._super(...arguments);
        this.changeset = new Changeset(this.get('user'), lookupValidator(TCRUserValidations), TCRUserValidations);
        if( !this.get('isUserAdmin') ){
            this.changeset.set('agent', this.get('current_user.user'));
        }
    },
    actions: {
        adminStatusChanged(status) {
            this.set('user.isAdmin', status);
        },
        titleChanged(title){
            this.set('changeset.title', title);
            this.get('changeset').validate('title');
            this.user.set('title', title);
        },
        updateUserBirthDate(date){
            this.set('changeset.birthDate', date);
            this.get('changeset').validate('birthDate');
            this.set('user.birthDate', date);
        },
        saveUser(user) {
            this.get('changeset').validate();
            if (this.get('changeset').get('isValid')) {
                this.set('isLoading', true);
                user.save().then(() => {
                    this.toast.success(Translator.trans('User saved!'));
                    this.set('isLoading', false);
                    this.get('routing').transitionTo('dashboard.users.users-customers');
                }, (resp) => {
                    let errorMessage = resp.errors[0].detail;
                    this.toast.error(Translator.trans(errorMessage));
                    this.set('isLoading', false);
                });
            }
        },
        changeCountry(country){
            this.set('changeset.country', country);
            this.get('changeset').validate('country');
            this.set('user.country', country);
        },
        updateLanguage(lang){
            this.set('changeset.language', lang);
            this.get('changeset').validate('language');
            this.set('user.language', lang);
        },
        addedFile: function (file) {
            let _user = this.user;
            _user.set('imageName', file.name);
            let reader = new FileReader();
            reader.onloadend = function () {
                let imgBase64 = reader.result;
                _user.set('base64Content', imgBase64);
            };
            reader.readAsDataURL(file);
        },

        removedFile: function () {
            if(!this.get('maxFilesReached')) {
                this.set('user.base64Content', null);
                this.set('user.imageName', null);
            }
        },

        maxFilesReached: function (reached) {
            this.set('maxFilesReached', reached);
        },

        /** validations */
        reset(changeset) {
            return changeset.rollback();
        },

        agentSelected(agent){
            this.set('changeset.agent', agent);
            this.get('changeset').validate('agent');
        },

        validateProperty(changeset, property) {
            return changeset.validate(property);
        }
    },

    searchQuery(page, text, perPage) {
        return this.get('store').query('agent', {page:page, rows:perPage, search: text, searchField: 'agent.email'}).then(results => results);
    }
});