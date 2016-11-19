import Ember from 'ember';

export default Ember.Component.extend({

    store: Ember.inject.service(),

    userCity: null,
    userStreet: null,
    address: Ember.observer('userCity', 'userStreet', function() {
        this.set('user.address', this.get('userCity')+', '+this.get('userStreet'));
    }),

    init() {
        this._super(...arguments);

        let address = this.get('user').get('address');
        this.set('userCity', address.split(',')[0]);
        this.set('userStreet', address.split(',')[1]);
    },

    actions: {
        setTitle(newTitle){
            this.set('user.title', newTitle);
        },

        updateUserBirthDate(date){
            this.set('user.birthDate', date.toJSON());
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

        saveUser(user) {
            user.save().then(() => {
                this.toast.success('Updated!');
            }, () => {
                this.toast.error('Error occurred!');
            });
        },
    }
});
