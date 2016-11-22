import Ember from 'ember';

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

    actions: {
        languageChanged: function (languageKey) {
            this.get('onLanguageSelected')(languageKey);
        }
    }

});