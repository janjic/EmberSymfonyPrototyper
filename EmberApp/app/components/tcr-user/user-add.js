import Ember from 'ember';
import TCRUserValidations from '../../validations/tcr-user';

export default Ember.Component.extend({
    store: Ember.inject.service('store'),
    validations: TCRUserValidations,

    userCity: '',
    userStreet: '',
    address: Ember.observer('userCity', 'userStreet', function() {
        this.set('user.address', this.get('userCity')+', '+this.get('userStreet'));
    }),

    passwordRepeat: '',
    emailRepeat: '',

    actions: {
        setTitle(newTitle){
            this.set('user.title', newTitle);
        },

        updateUserBirthDate(date){
            this.set('user.birthDate', date);
        },
        saveUser(user) {
            user.save().then(() => {
                this.toast.success('User saved!');
            }, () => {
                this.toast.error('Data not saved!');
            });
        },

        addedFile: function (file) {
            var img = this.model.get('image');
            img.set('name', file.name);
            var reader = new FileReader();
            reader.onloadend = function () {
                var imgBase64 = reader.result;
                img.set('base64_content', imgBase64);
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