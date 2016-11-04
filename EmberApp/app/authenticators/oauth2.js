import OAuth2PasswordGrant from 'ember-simple-auth/authenticators/oauth2-password-grant';
import config from './../config/environment';
import Ember from 'ember';

const {
    RSVP,
    run
} = Ember;

export default OAuth2PasswordGrant.extend({
    serverTokenEndpoint: '/oauth/v2/token',
    serverTokenRevocationEndpoint: '/oauth/v2/token',

    makeRequest(url, data) {

        if (!Object.is(data.token_type_hint, undefined)) {
            if (Object.is(data.token_type_hint, 'access_token')) {
                data.grant_type = 'token';
            } else {
                data.grant_type = data.token_type_hint;
            }

            delete data.token_type_hint;
        } else {
            data.client_id = config.APP.clientId;
            data.client_secret = config.APP.clientSecret;
        }

        return this._super(...arguments);
    },
    invalidate(){
        function success(resolve) {
            run.cancel(this._refreshTokenTimeout);
            delete this._refreshTokenTimeout;
            resolve();
        }
        return new RSVP.Promise((resolve) => {
            success.apply(this, [resolve]);
        });
    }
});