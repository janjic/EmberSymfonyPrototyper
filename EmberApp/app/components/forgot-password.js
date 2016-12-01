import Ember from 'ember';
import ForgotPasswordValidations from '../validations/forgot-password';
import request from 'ember-ajax/request';
const Routing = window.Routing;
const Translator = window.Translator;

export default Ember.Component.extend({
    validations: ForgotPasswordValidations,
    email: '',
    init() {
        this._super(...arguments);
    },
    actions: {
        reset(changeset) {
            if (changeset.validate() && changeset.get('isValid')) {
                let options = {
                    method: 'POST',
                    data: {
                        usernameOrPassword: changeset.get('email')
                    }
                };
                this.set('isLoading', true);
                request(Routing.generate('api_agent_forgot_password'), options).then(response => {
                    this.set('isLoading', false);
                    switch (parseInt(response.status)) {
                        case 41:
                            this.toast.error(Translator.trans('password.already.requested.%ttl%', {'ttl': response.time}));
                            break;
                        case 21:
                            this.toast.success(Translator.trans('password.resetting.link.sent'));
                            break;
                        case 26:
                            this.toast.error(Translator.trans('password.user.with.email.not.exist'));
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
