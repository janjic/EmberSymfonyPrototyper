import Ember from 'ember';
import NewPasswordValidations from '../validations/new-password';
import LoadingStateMixin from '../mixins/loading-state';
import request from 'ember-ajax/request';
const {Translator, Routing, ApiCode} = window;
const { inject: { service } } = Ember;

export default Ember.Component.extend(LoadingStateMixin,{
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
                this.showLoader('loading.sending.data');
                request(Routing.generate('api_agent_reset_password',  {token: this.get('token')}), options).then(response => {
                    switch (parseInt(response.status)) {
                        case ApiCode.USER_WITH_TOKEN_DOES_NOT_EXIST:
                            this.toast.error(Translator.trans('password.changed.invalid.token'));
                            this.disableLoader();
                            break;
                        case ApiCode.PASSWORDS_CHANGED_OK:
                            this.toast.success(Translator.trans('password.changed.successfully'));
                            this.setLoadingText('loading.logging.user');
                            this.get('session').authenticate('authenticator:oauth2', response.email, changeset.get('password')).catch((reason) => {
                                this.toast.error(Translator.trans('password.changed.invalid.token'));
                                this.disableLoader();
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