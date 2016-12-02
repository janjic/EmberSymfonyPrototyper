import Ember from 'ember';
import LoadingStateMixin from '../mixins/loading-state';
const { inject: { service }, Component } = Ember;

export default Component.extend(LoadingStateMixin,{
    session: service('session'),
    actions: {
        authenticateWithOAuth2() {
            this.showLoader();
            let { identification, password } = this.getProperties('identification', 'password');
            this.get('session').authenticate('authenticator:oauth2', identification, password).catch((reason) => {
                this.disableLoader();
                this.set('errorMessage', reason.error);
            });
        }
    }
});