import Ember from 'ember';

export default Ember.Controller.extend({
    store: Ember.inject.service('store'),
    firstNameNotFocused: true,
    firstNameValid: Ember.computed('model.firstName', function () {
        return validateStringInput(this, 'firstName','firstNameNotFocused', 2, 'string', 'First name not valid');

    }),
    lastNameNotFocused: true,
    lastNameValid: Ember.computed('model.lastName', function () {
        return validateStringInput(this, 'lastName','lastNameNotFocused', 2, 'string', 'Last name not valid');
    }),
    actions: {
        updateUserBirthDate(date){
            var user = this.model;
            user.set('birthDate', date);
        },
        saveUser(user) {
            var model = this.get('model');
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
    }
});

function validateStringInput(ctx, inputName, flag, length, validationType, message){

    if (validationType == 'email') {
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        var inputValid = re.test(ctx.get('mode.'+inputName));
    } else {
        var inputValid = ctx.get('model.'+inputName+'.length') >= length;
    }

    let valid = (inputValid || ctx.get(flag));
    ctx.set(flag, false);
    return {
        valid,
        message
    };

}
