import Ember from 'ember';
import TCRUserValidations from '../../validations/tcr-user-add';
import Changeset from 'ember-changeset';
import lookupValidator from './../../utils/lookupValidator';

export default Ember.Component.extend({
    TCRUserValidations,
    store: Ember.inject.service('store'),
    userCity: null,
    userStreet: null,
    address: Ember.computed('userCity', 'userStreet', function() {
        this.set('changeset.address', this.get('userCity')+', '+this.get('userStreet'));
        console.log(this.get('changeset.address'));

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
            // this.set('user.birthDate', date);
            this.set('changeset.birthDate', date);
            this.get('changeset').validate('birthDate');
            var agent = this.model;
            this.set('user.birthDate', date)
        },
        saveUser(user) {
            this.get('changeset').validate();
            if (this.get('changeset').get('isValid')) {
                user.save().then(() => {
                    this.toast.success('User saved!');
                }, () => {
                    this.toast.error('Data not saved!');
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
            var img = this.user.get('image');
            img.set('name', file.name);
            var reader = new FileReader();
            reader.onloadend = function () {
                var imgBase64 = reader.result;
                img.set('base64Content', imgBase64);
            };
            reader.readAsDataURL(file);
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