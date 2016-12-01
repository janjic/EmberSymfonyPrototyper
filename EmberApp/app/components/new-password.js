import Ember from 'ember';
import NewPasswordValidations from '../validations/new-password';
import request from 'ember-ajax/request';
const Routing = window.Routing;
const Translator = window.Translator;
Translator.locale = 'en';
const { inject: { service } } = Ember;

export default Ember.Component.extend({
    validations: NewPasswordValidations,
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
                request(Routing.generate('api_agent_reset_password',  {token: this.get('token')}), options).then(response => {
                    switch (parseInt(response.status)) {
                        case 24:
                            this.toast.error(Translator.trans('password.changed.invalid.token'));
                            break;
                        case 22:
                            this.toast.success(Translator.trans('password.changed.successfully'));
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