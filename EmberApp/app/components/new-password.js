import Ember from 'ember';
import NewPasswordValidations from '../validations/new-password';
import request from 'ember-ajax/request';
const Routing = window.Routing;
const Translator = window.Translator;
const { inject: { service } } = Ember;

export default Ember.Component.extend({
    validations: NewPasswordValidations,
    isLoading:false,
    loadingText: '',
    password: '',
    passwordConfirmation: '',
    session: service('session'),
    actions: {
        setNewPassword(changeset) {
            if (changeset.validate() && changeset.get('isValid')) {
                let options = {
                    method: 'POST',
                    data: {
                        password: changeset.get('password'),
                        passwordConfirmation: changeset.get('passwordConfirmation')
                    }
                };
                this.set('isLoading', true);
                this.set('loadingText', 'loading.sending.data');
                request(Routing.generate('api_agent_reset_password',  {token: this.get('token')}), options).then(response => {
                    switch (parseInt(response.status)) {
                        case 24:
                            this.toast.error(Translator.trans('password.changed.invalid.token'));
                            this.set('isLoading', false);
                            break;
                        case 22:
                            this.toast.success(Translator.trans('password.changed.successfully'));
                            this.set('loadingText', 'loading.logging.user');
                            this.get('session').authenticate('authenticator:oauth2', response.email, changeset.get('password')).catch((reason) => {
                                this.set('errorMessage', reason.error);
                            });
                            break;
                        default:
                            return;
                    }
                });
            }

        },
        validateProperty(changeset, property) {
            return changeset.validate(property);
        }
    }
});