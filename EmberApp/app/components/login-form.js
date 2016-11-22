import Ember from 'ember';

const { inject: { service }, Component } = Ember;

export default Component.extend({
    session: service('session'),
    actions: {
        authenticateWithOAuth2() {
            this.set('isLoading', true);
            let { identification, password } = this.getProperties('identification', 'password');
            this.get('session').authenticate('authenticator:oauth2', identification, password).catch((reason) => {
                this.set('isLoading', false);
                this.set('errorMessage', reason.error);
            });
        }
    }
});