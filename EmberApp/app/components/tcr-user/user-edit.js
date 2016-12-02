import Ember from 'ember';
import TCRUserValidations from '../../validations/tcr-user';
import Changeset from 'ember-changeset';
import lookupValidator from './../../utils/lookupValidator';

export default Ember.Component.extend({
    store: Ember.inject.service(),
    TCRUserValidations,
    userCity: null,
    userStreet: null,
    address: Ember.observer('userCity', 'userStreet', function() {
        this.set('changeset.address', this.get('userCity')+', '+this.get('userStreet'));
    }),

    init() {
        this._super(...arguments);
        this.changeset = new Changeset(this.get('user'), lookupValidator(TCRUserValidations), TCRUserValidations);
        let address = this.get('user').get('address');
        this.set('userCity', address.split(',')[0].trim());
        this.set('userStreet', address.split(',')[1].trim());
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
            this.set('user.birthDate', date);
        },

        updateLanguage(lang){
            this.set('user.language', lang);
        },

        addedFile: function (file) {
            this.set('user.image', null);
            var img = this.get('store').createRecord('image');
            img.set('name', file.name);
            var reader = new FileReader();
            reader.onloadend = function () {
                var imgBase64 = reader.result;
                img.set('base64Content', imgBase64);

            };
            reader.readAsDataURL(file);
            this.set('user.image', img);
        },

        removedFile: function () {
            this.set('user.image', null);
        },

        /** crud */

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

        /** validations */

        reset(changeset) {
            return changeset.rollback();
        },

        validateProperty(changeset, property) {
            return changeset.validate(property);
        }
    }
});
