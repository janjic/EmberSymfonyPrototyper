import Ember from 'ember';
import AgentValidations from '../validations/edit-agent';
import AddressValidations from '../validations/address';
import Changeset from 'ember-changeset';
import { withoutProxies } from '../utils/proxy-helpers';
import lookupValidator from '../utils/lookupValidator';


export default Ember.Component.extend({
    AgentValidations,
    AddressValidations,
    currentUser: Ember.inject.service('current-user'),
    isModalOpen:false,
    store: Ember.inject.service(),
    init() {
        this._super(...arguments);
        this.changeset = new Changeset(this.get('currentUser.user'), lookupValidator(AgentValidations), AgentValidations);
        let address = withoutProxies(this.get('currentUser.user.address'));
        if (Object.is (address, null)) {
            address = this.get('store').createRecord('address');
            this.get('currentUser.user').set('address', address);
        }
        this.addressChangeset = new Changeset(address, lookupValidator(AddressValidations), AddressValidations);
    },
    actions: {
        updateAgentBirthDate(date){
            this.set('changeset.birthDate', date);
            this.get('changeset').validate('birthDate');
            let agent = this.get('currentUser.user');
            agent.set('birthDate',date);
        },
        titleChanged(title){
            this.changeset.set('title', title);
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
            if (!file.url) {
                this.set('currentUser.user.image', null);
                let img = this.get('store').createRecord('image');
                img.set('name', file.name);
                let reader = new FileReader();
                reader.onloadend = function () {
                    let imgBase64 = reader.result;
                    img.set('base64Content', imgBase64);

                };
                reader.readAsDataURL(file);
                this.set('currentUser.user.image', img);
            }

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

        /** validations */
        reset(changeset) {
            return changeset.rollback();
        },
        validateProperty(changeset, property) {
            return changeset.validate(property);
        },

        openModal() {
            this.set('isModalOpen', true);
        }
    }
});
