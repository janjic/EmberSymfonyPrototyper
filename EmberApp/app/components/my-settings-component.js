import Ember from 'ember';
import SettingsValidations from '../validations/my-settings';
import Changeset from 'ember-changeset';
//import lookupValidator from './../utils/lookupValidator';
import lookupValidator from 'ember-changeset-validations';
import LoadingStateMixin from '../mixins/loading-state';
import { withoutProxies } from './../utils/proxy-helpers';
const { Translator } = window;

export default Ember.Component.extend(LoadingStateMixin,{
    SettingsValidations,
    store: Ember.inject.service(),

    init(){
        this._super(...arguments);
        this.changeset = new Changeset(this.get('settings'), lookupValidator(SettingsValidations), SettingsValidations);
        this.set('subComponentValidations', []);
    },

    image: Ember.Object.create({
        base64Content: null,
        name: null
    }),
    currentImage: null,

    getImage() {
        if (this.get('changeset.image') && this.get('changeset.image.id')) {
            return this.get('changeset.image');
        }

        return this.get('image');
    },

    actions: {
        saveSettings(){
            this.get('changeset').validate();
            //let validCommissions = this.get('isValidCommissions').every((valid)=>valid===true);
            //let validBonuses = this.get('isValidBonus').every((valid)=>valid===true);

            let isValidSubComponents = this.get('subComponentValidations').every((changeSet)=>changeSet.get('isValid'));

            if (this.get('changeset').get('isValid') && isValidSubComponents) {
                this.showLoader('loading.sending.data');
                this.setLoadingText('loading.sending.data');

                this.get('subComponentValidations').forEach((changeSet)=>{
                    changeSet.execute();
                });

                let img = this.getImage();
                //WE can send image to server
                if (!img.get('id') && ((img.get('base64Content')))) {
                    this.get('addImage')(this.get('changeset'), img);
                } else if (img.get('id') && !img.get('name') && !img.get('webPath') && !img.get('base64Content')) {
                    img = withoutProxies(img);
                    img.deleteRecord();
                    this.get('changeset').set('image', null);
                }

                this.get('changeset').save().then(()=>{
                    this.disableLoader();
                    this.get('settings').reload();
                    this.toast.success( Translator.trans('models.agent.updated.profile') );
                }, ()=>{
                    this.toast.error( Translator.trans('models.agent.file.error') );
                    this.disableLoader();
                });
            }
        },
        registerSubComponentChangeset(changeSet){
            this.get('subComponentValidations').push(changeSet);
        },
        validateProperty(changeset, property) {
            return changeset.validate(property);
        },
        updateLanguage(lang){
            this.set('changeset.language', lang);
            this.get('changeset').validate('language');
        },
        addedFile (file) {
            if (!file.url) {
                let image = this.getImage();
                image.set('webPath', null);
                image.set('name', file.name);
                let reader = new FileReader();
                reader.onloadend = function () {
                    let imgBase64 = reader.result;
                    image.set('base64Content', imgBase64);
                };
                reader.readAsDataURL(file);
            }
        },
        removedFile() {
            if(!this.get('maxFilesReached')) {
                let img = this.getImage();
                img.set('name', null);
                img.set('webPath', null);
                img.set('base64Content', null);
            }
        },

        maxFilesReached: function (reached) {
            this.set('maxFilesReached', reached);
        }
    },

    willDestroyElement() {
        this._super(...arguments);
        let imgObj = this.getImage();
        if( imgObj.get('id') ) {
            withoutProxies(imgObj).rollbackAttributes();
        }
    }
});
