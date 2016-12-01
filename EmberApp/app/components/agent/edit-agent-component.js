import Ember from 'ember';
import AgentValidations from '../../validations/edit-agent';
import AddressValidations from '../../validations/address';
import Changeset from 'ember-changeset';
import lookupValidator from './../../utils/lookupValidator';

export default Ember.Component.extend({
    AgentValidations,
    AddressValidations,
    store: Ember.inject.service(),
    model: null,
    init() {
        this._super(...arguments);
        this.changeset = new Changeset(this.get('model'), lookupValidator(AgentValidations), AgentValidations);
        this.addressChangeset = new Changeset(this.get('model.address'), lookupValidator(AddressValidations), AddressValidations);
        console.log(this.model.get('superior'));
    },
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
            this.set('changeset.birthDate', date);
            this.get('changeset').validate('birthDate');
            var agent = this.model;
            agent.set('birthDate',date);
        },
        editAgent(agent){
            this.get('changeset').validate();
            this.get('addressChangeset').validate();
            if ( this.get('changeset').get('isValid') && this.get('addressChangeset').get('isValid')) {
                agent.set('address', this.get('addressChangeset._content'));
                agent.save().then(() => {
                    this.toast.success('Agent saved!');
                }, () => {
                    this.toast.error('Data not saved!');
                });
            }
        },
        addedFile: function (file) {
            this.set('model.image', null);
            var img = this.get('store').createRecord('image');
            img.set('name', file.name);
            var reader = new FileReader();
            reader.onloadend = function () {
                var imgBase64 = reader.result;
                img.set('base64Content', imgBase64);

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

    },

    validateDateInput(date)
    {
        if(date){
            if(date < (new Date()).setYear((new Date().getFullYear()-18))) {
                this.set('dateInputValid', true);
                return true;
            } else {
                this.set('dateInputValid', false);
                return true;
            }
        } else {
            this.set('dateInputValid', false);
            return true;
        }
    }
});
