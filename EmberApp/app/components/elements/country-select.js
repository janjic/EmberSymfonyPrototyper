import Ember from 'ember';

export default Ember.Component.extend({
    countries: [
        'Andorra',
        'Austria',
        'Belgium',
        'Bulgaria',
        'Croatia',
        'Cyprus',
        'Czech Republic',
        'Denmark',
        'Estonia',
        'Faroe Island',
        'Finland',
        'France',
        'Germany',
        'Great Britain',
        'Greece',
        'Hungary',
        'Iceland',
        'Ireland',
        'Italy',
        'Latvia',
        'Lithuania',
        'Luxembourg',
        'Malta',
        'Monaco',
        'Netherlands',
        'Norway',
        'Liechtenstein',
        'Poland',
        'Portugal',
        'Romania',
        'San Marino',
        'Serbia',
        'Slovakia',
        'Slovenia',
        'Spain',
        'Sweden',
        'Switzerland',
        'Vatican State'
    ],

    selectedCountry: null,

    actions: {
        changeCountry: function (country) {
            this.get('onCountryChange')(country);
        }
    }

});
