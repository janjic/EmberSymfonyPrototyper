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
                clientId: "1_4016luc3cx2ccgo4kokw8g4owoo844wwoosck0ooow0c88ssos",
                clientSecret: "5ldb4oy2794w0c044wwkgckgw400gwskkwocckkkwwws8sss8c"
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

    

