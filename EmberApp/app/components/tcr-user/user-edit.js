import Ember from 'ember';
import TCRUserValidations from '../../validations/tcr-user';
import Changeset from 'ember-changeset';
import lookupValidator from './../../utils/lookupValidator';

const { Translator } = window;

export default Ember.Component.extend({
    store: Ember.inject.service(),
    routing: Ember.inject.service('-routing'),
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
            if (file instanceof Blob) {
                let _user = this.user;
                _user.set('filePath', null);
                _user.set('imageId', null);
                _user.set('imageName', file.name);
                let reader = new FileReader();
                reader.onloadend = function () {
                    let imgBase64 = reader.result;
                    _user.set('base64Content', imgBase64);
                };
                reader.readAsDataURL(file);
            }
        },

        removedFile: function () {
            if(!this.get('maxFilesReached')){
                this.set('user.base64Content', null);
                this.set('user.imageName', null);
                this.set('user.filePath', null);
                this.set('user.imageId', null);
            }
        },

        maxFilesReached: function (reached) {
            this.set('maxFilesReached', reached);
        },

        changeIsAdmin(val) {
            this.set('user.isAdmin', val);
        },

        /** crud */

        saveUser(user) {
            this.get('changeset').validate();
            if (this.get('changeset').get('isValid')) {
                user.save().then(() => {
                    this.toast.success(Translator.trans('User updated!'));
                    this.get('routing').transitionTo(this.get('viewAllRoute'));
                }, () => {
                    this.toast.error(Translator.trans('Data not updated!'));
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
