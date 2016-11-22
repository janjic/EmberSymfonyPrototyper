import Ember from 'ember';
import TCRUserValidations from '../../validations/tcr-user';

export default Ember.Component.extend({
    store: Ember.inject.service(),
    validations: TCRUserValidations,

    userCity: null,
    userStreet: null,
    address: Ember.observer('userCity', 'userStreet', function() {
        this.set('user.address', this.get('userCity')+', '+this.get('userStreet'));
    }),

    init() {
        this._super(...arguments);

        let address = this.get('user').get('address');
        this.set('userCity', address.split(',')[0].trim());
        this.set('userStreet', address.split(',')[1].trim());
    },

    actions: {
        setTitle(newTitle){
            this.set('user.title', newTitle);
        },

        updateUserBirthDate(date){
            this.set('user.birthDate', date.toJSON());
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
                img.set('base64_content', imgBase64);

            };
            reader.readAsDataURL(file);
            this.set('user.image', img);
        },

        removedFile: function () {
            this.set('user.image', null);
        },

        /** crud */

        saveUser(user) {
            user.save().then(() => {
                this.toast.success('Updated!');
            }, () => {
                this.toast.error('Error occurred!');
            });
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
