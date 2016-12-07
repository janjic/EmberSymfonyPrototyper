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
    image: Ember.Object.create({
        base64: null,
        name: null,
    }),
    actions: {
        updateAgentBirthDate(date){
            this.set('changeset.birthDate', date);
            this.get('changeset').validate('birthDate');
            let agent = this.model;
            agent.set('birthDate', date);
        },
        addedFile (file) {
            this.set('image.name', file.name);
            let reader = new FileReader();
            let $this = this;
            reader.onloadend = function () {
                let imgBase64 = reader.result;
                $this.set('image.base64', imgBase64);
            };
            reader.readAsDataURL(file);
        },

        onDropzoneInitialise() {
            console.log('EVNET JE', arguments);
        },

        removedFile() {
            this.set('image.name', null);
            this.set('image.base64', null);
        },
        saveAgent(agent) {
            let changeSet = this.get('changeset');
            let addressChangeSet = this.get('addressChangeset');
            let isValidated      =  changeSet.validate() && addressChangeSet.validate();
            let isValid          = isValidated && changeSet.get('isValid') && addressChangeSet.get('isValid');
            if (isValid ) {
                agent.set('address', this.get('addressChangeset._content'));
                let img = this.get('image');
                if (img.get('base64')) {
                    this.get('addImage')(img);
                }
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
            let prop = property;
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
