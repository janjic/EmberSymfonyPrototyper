import Ember from 'ember';
const {computed} = Ember;
export default Ember.Component.extend({
    languages: [{
            name: 'English',
            key: 'en'
        },{
            name: 'German',
            key: 'de'
        },{
            name: 'Spanish',
            key: 'es'
        },{
            name: 'French',
            key: 'fr'
        }
    ],

    selectedLanguage: null,
    currentLanguage: computed('nationality', function() {
        return this.get('languages').findBy('key', this.get('nationality'));
    }),

    actions: {
        languageChanged: function (language) {
            this.set('selectedLanguage', language);
            this.get('onLanguageSelected')(language ? language.key : language);
        }
    }

});