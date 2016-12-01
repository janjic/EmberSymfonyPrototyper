import Ember from 'ember';
import TCRUserValidations from '../../validations/tcr-user';
import AddressValidations from '../../validations/address';
import Changeset from 'ember-changeset';
import lookupValidator from './../../utils/lookupValidator';

export default Ember.Component.extend({
    AddressValidations,
    TCRUserValidations,
    store: Ember.inject.service('store'),
    passwordRepeat: '',
    emailRepeat: '',
    init() {
        this._super(...arguments);
        this.changeset = new Changeset(this.get('model'), lookupValidator(TCRUserValidations), TCRUserValidations);
        this.addressChangeset = new Changeset(this.get('model.address'), lookupValidator(AddressValidations), AddressValidations);
    },

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