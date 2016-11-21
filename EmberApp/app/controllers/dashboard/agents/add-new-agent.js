import Ember from 'ember';

export default Ember.Controller.extend({
    actions: {
        updateAgentBirthDate(date){
            var agent = this.model;
            agent.set('birthDate', date);
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
        saveAgent(agent) {
            agent.save().then(() => {
                this.toast.success('Agent saved!');
            }, () => {
                this.toast.error('Data not saved!');
            });
        },
        roleSelected(group){
            this.model.set('group', group);
        },
        agentSelected(agent){
            this.model.set('superior', agent);
        },
        titleChanged(title){
            this.model.set('title', title);
        },
        updateLanguage(lang){
            this.set('model.nationality', lang);
        },
        changeCountry(country){
            this.set('model.address.country', country);
        },
    }
});
