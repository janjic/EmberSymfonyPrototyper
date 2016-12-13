import Ember from 'ember';
import TCRUserValidations from '../../validations/tcr-user-add';
import Changeset from 'ember-changeset';
import lookupValidator from './../../utils/lookupValidator';

const { Translator } = window;

export default Ember.Component.extend({
    TCRUserValidations,
    store: Ember.inject.service('store'),
    routing: Ember.inject.service('-routing'),
    userCity: null,
    userStreet: null,
    address: Ember.computed('userCity', 'userStreet', function() {
        this.set('changeset.address', this.get('userCity')+', '+this.get('userStreet'));
    }),
    init() {
        this._super(...arguments);
        this.changeset = new Changeset(this.get('user'), lookupValidator(TCRUserValidations), TCRUserValidations);
    },
    actions: {
        titleChanged(title){
            this.set('changeset.title', title);
            this.get('changeset').validate('title');
            this.user.set('title', title);
        },
        updateUserBirthDate(date){
            this.set('changeset.birthDate', date);
            this.get('changeset').validate('birthDate');
            var agent = this.model;
            this.set('user.birthDate', date);
        },
        saveUser(user) {
            this.get('changeset').validate();
            if (this.get('changeset').get('isValid')) {
                user.save().then(() => {
                    this.toast.success(Translator.trans('User saved!'));
                    this.get('routing').transitionTo('dashboard.users.users-customers');
                }, (resp) => {
                    let errorMessage = resp.errors[0].detail;
                    this.toast.error(Translator.trans(errorMessage));
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
            this.set('user.base64Content', null);
            this.set('user.imageName', null);
        },

        /** validations */
        reset(changeset) {
            return changeset.rollback();
        },

        validateProperty(changeset, property) {
            return changeset.validate(property);
        }
    }
});