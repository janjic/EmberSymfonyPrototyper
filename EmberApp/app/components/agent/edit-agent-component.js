import Ember from 'ember';
import AgentValidations from '../../validations/agent';

export default Ember.Component.extend({
    validations: AgentValidations,
    store: Ember.inject.service(),
    actions: {
        roleSelected(group){
            this.model.set('group', group);
        },
        agentSelected(agent){
            this.model.set('superior', agent);
        },
        titleChanged(title){
            this.model.set('title', title);
        },
        updateAgentBirthDate(date){
            var agent = this.model;
            agent.set('birthDate', date);
        },
        editAgent(agent){
            agent.save().then(() => {
                this.toast.success('Agent saved!');
            }, () => {
                this.toast.error('Data not saved!');
            });
        },
        addedFile: function (file) {
            this.set('model.image', null);
            var img = this.get('store').createRecord('image');
            img.set('name', file.name);
            var reader = new FileReader();
            reader.onloadend = function () {
                var imgBase64 = reader.result;
                img.set('base64_content', imgBase64);

            };
            reader.readAsDataURL(file);
            this.set('model.image', img);
        },

        removedFile: function () {
            this.set('model.image', null);
        },
        updateLanguage(lang){
            this.set('model.nationality', lang);
        },
        changeCountry(country){
            this.set('model.address.country', country);
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
