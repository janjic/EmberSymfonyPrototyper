import Ember from 'ember';
const Dropzone = window.Dropzone;

export default Ember.Controller.extend({
      actions: {
        updateUserBirthDate(date){
            this.model.set('birthDate', date);
        },
        saveUser(user) {
            user.save();
        },
        addedFile: function (file) {
            this.model.set('image', null);
            var img = this.store.createRecord('image');
            img.set('name', file.name);
            var reader = new FileReader();
            reader.onloadend = function () {
                var imgBase64 = reader.result;
                img.set('base64_content', imgBase64);

            };
            reader.readAsDataURL(file);
            this.model.set('image', img);
            this.model.set('baseImageUrl', this.model.get('image.base64_content'));
        },
    }
});
