import Ember from 'ember';
import AgentValidations from '../../validations/add-new-agent';
import AddressValidations from '../../validations/address';
import Changeset from 'ember-changeset';
import lookupValidator from './../../utils/lookupValidator';

export default Ember.Component.extend({
    AgentValidations,
    AddressValidations,
    dateInputValid: true,
    init() {
        this._super(...arguments);
        this.changeset = new Changeset(this.get('model'), lookupValidator(AgentValidations), AgentValidations);
        this.addressChangeset = new Changeset(this.get('model.address'), lookupValidator(AddressValidations), AddressValidations);
    },
    actions: {
        updateAgentBirthDate(date){
            this.set('changeset.birthDate', date);
            this.get('changeset').validate('birthDate');
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
        saveAgent(agent, address) {
            this.get('changeset').validate() && this.get('addressChangeset').validate();
            if (this.get('changeset').get('isValid') && this.get('addressChangeset').get('isValid')) {
                agent.set('address', this.get('addressChangeset._content'));
                agent.save().then(() => {
                    this.toast.success('Agent saved!');
                }, () => {
                    this.toast.error('Data not saved!');
                });
            }
        },
        roleSelected(group){
            this.model.set('group', group);
        },
        agentSelected(agent){
            this.model.set('superior', agent);
        },
        titleChanged(title){
            this.set('changeset.title', title);
            this.get('changeset').validate('title');
            this.model.set('title', title);
        },
        updateLanguage(lang){
            this.set('changeset.nationality', lang);
            this.get('changeset').validate('nationality');
            this.set('model.nationality', lang);
        },
        changeCountry(country){
            this.set('addressChangeset.country', country);
            this.get('addressChangeset').validate('country');
            this.set('model.address.country', country);
        },
        /** validations */
        reset(changeset) {
            return changeset.rollback();
        },
        validateProperty(changeset, property) {
            var prop = property;
            if(this.isObject(changeset.get(property))){
                prop = property+'.id';
            }
            return changeset.validate(property);
        },
    },

    validateDateInput(date) {
        return (date < (new Date()).setYear((new Date().getFullYear()-18)));
    },

    isObject(val) {
        if (val === null) { return false;}
        return ( (typeof val === 'function') || (typeof val === 'object') );
    },

});
