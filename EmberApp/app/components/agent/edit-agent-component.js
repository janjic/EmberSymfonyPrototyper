import Ember from 'ember';
import AgentValidations from '../../validations/edit-agent';
import AddressValidations from '../../validations/address';
import Changeset from 'ember-changeset';
import lookupValidator from './../../utils/lookupValidator';
const {assign} = Ember;
import LoadingStateMixin from '../../mixins/loading-state';

export default Ember.Component.extend(LoadingStateMixin,{
    AgentValidations,
    AddressValidations,
    store: Ember.inject.service(),
    model: null,
    init() {
        this._super(...arguments);
        this.changeset = new Changeset(this.get('model'), lookupValidator(AgentValidations), AgentValidations);
        this.addressChangeset = new Changeset(this.get('model.address'), lookupValidator(AddressValidations), AddressValidations);
    },

    didInsertElement() {
        this._super(...arguments);
        if (this.get('model.image.id')) {
           this.set('image',Ember.Object.create({
                base64Content: null,
                name: null,
            }));
        } else {
            this.set('image', this.get('model.image'));
        }
    },
    actions: {
        roleSelected(group){
            this.changeset.set('group', group);
        },
        titleChanged(title){
            this.changeset.set('title', title);
        },
        updateAgentBirthDate(date){
            this.set('changeset.birthDate', date);
            this.get('changeset').validate('birthDate');
            this.set('model.birthDate',date);
        },
        removedFile() {
            this.set('image.name', null);
            this.set('image.base64Content', null);
        },
        editAgent(){
            let agent = this.get('model');
            this.changeset.validate();
            this.addressChangeset.validate();
            if (this.changeset.get('isValid') && this.addressChangeset.get('isValid')) {
                agent.set('address', this.get('addressChangeset._content'));
                let img = this.get('image');
                //old removed image
                if (img.get('id') && !img.get('base64Content')) {
                    img.deleteRecord();
                    agent.set('model.image', null);
                    //it is a new image
                } else if (!img.get('id') && img.get('base64Content')) {
                    let newImage = this.store.createRecord('image');
                    assign(newImage, img);
                    agent.set('image', newImage);
                    img = null;
                }
                agent.save().then(() => {
                    this.toast.success('Agent saved!');
                }, () => {
                    this.toast.error('Data not saved!');
                });
            }
        },
        addedFile(file) {
            let img = this.get('image');
            img.set('name', file.name);
            let reader = new FileReader();
            reader.onloadend = function () {
                let imgBase64 = reader.result;
                img.set('base64Content', imgBase64);
            };
            reader.readAsDataURL(file);
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
});
