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
                clientId: "1_2h340d1qjku8w0ow0o80cwk8wcswkcswo0ocwcw4sog0sc0swo",
                clientSecret: "4tzk7y386q68wgg0gokk4ckc8kgs0g0cw0w80w4sog884ccs0k"
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

    

