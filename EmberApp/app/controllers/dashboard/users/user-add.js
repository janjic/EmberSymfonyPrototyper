import Ember from 'ember';

export default Ember.Controller.extend({
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
            this.model.set('birthDate', date);
        },
        saveUser(user) {
            user.save().then(()=> {
                this.set('model', this.store.createRecord('user'));
                this.set('model.image', this.store.createRecord('image'));
                this.set('model.address', this.store.createRecord('address'));
            }) ;
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
            console.log(img.get('base64_content'));
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
