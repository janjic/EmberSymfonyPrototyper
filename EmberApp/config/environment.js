     module.exports = function(environment) {
        var ENV = {
            modulePrefix: 'ember-app',
            environment: environment,
            rootURL: '/app/',
            locationType: 'auto',
            EmberENV: {
                FEATURES: {
                    // Here you can enable experimental features on an ember canary build
                    // e.g. 'with-controller': true
                },
                EXTEND_PROTOTYPES: {
                    // Prevent Ember Data from overriding Date.parse.
                    Date: false
                }
            },

            APP: {
                clientId: "1_31b5hz04k8u844ogww0okkkos8ocgowc00o0kkkc88c4wwskgc",
                clientSecret: "5e52vtq9pgkkkswwk848wcs0sk8g8ggccgc4ws00k4080c8cgk"
                // Here you can pass flags/options to your application instance
                // when it is created
            }
        };

        if (environment === 'development') {
            // ENV.APP.LOG_RESOLVER = true;
            // ENV.APP.LOG_ACTIVE_GENERATION = true;
            // ENV.APP.LOG_TRANSITIONS = true;
            // ENV.APP.LOG_TRANSITIONS_INTERNAL = true;
            // ENV.APP.LOG_VIEW_LOOKUPS = true;
        }

        if (environment === 'test') {
            // Testem prefers this...
            ENV.locationType = 'none';

            // keep test console output quieter
            ENV.APP.LOG_ACTIVE_GENERATION = false;
            ENV.APP.LOG_VIEW_LOOKUPS = false;

            ENV.APP.rootElement = '#ember-testing';
        }

        if (environment === 'production') {

        }

        return ENV;
    };

    

