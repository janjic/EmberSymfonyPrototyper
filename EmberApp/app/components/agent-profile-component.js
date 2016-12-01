import Ember from 'ember';

export default Ember.Component.extend({
    currentUser: Ember.inject.service('current-user'),
    store: Ember.inject.service(),
    actions: {
        updateAgentBirthDate(date){
            let agent = this.get('currentUser.user');
            agent.set('birthDate', date);
        },
        titleChanged(title){
            let agent = this.get('currentUser.user');
            agent.set('title', title);
        },
        editAgent(agent){
            agent.save().then(()=> function () {
                this.toast.success('Profile saved!');
            },() => function () {
                this.toast.error('Profile not saved!');
            })
        },
        addedFile: function (file) {
            this.set('currentUser.user.image', null);
            var img = this.get('store').createRecord('image');
            img.set('name', file.name);
            var reader = new FileReader();
            reader.onloadend = function () {
                var imgBase64 = reader.result;
                img.set('base64_content', imgBase64);

            };
            reader.readAsDataURL(file);
            this.set('currentUser.user.image', img);
        },
        removedFile: function () {
            this.set('currentUser.user.image', null);
        },
        updateLanguage(lang){
            this.set('currentUser.user.nationality', lang);
        },
        changeCountry(country){
            this.set('currentUser.user.address.country', country);
        },
    }
});
