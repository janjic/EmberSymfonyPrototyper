import Ember from 'ember';
import ChangePasswordValidation from '../validations/change-password';
const { inject: { service } } = Ember;
const Routing= window.Routing;
export default Ember.Component.extend({
    authorizedAjax: service('authorized-ajax'),
    validations: ChangePasswordValidation,
    password: '',
    passwordConfirmation: '',
    oldPassword: '',
    actions: {
        setNewPassword(changeset) {
            if (changeset.validate() && changeset.get('isValid')) {
                let options = {
                        oldPassword: changeset.get('oldPassword'),
                        password: changeset.get('password'),
                        passwordConfirmation: changeset.get('passwordConfirmation')
                };
                this.get('authorizedAjax').sendAuthorizedRequest(options, 'POST', (Routing.generate('api_agent_change_password'))).then(response => {
                    console.log(response);
                });
            }

        },
        validateProperty(changeset, property) {
            return changeset.validate(property);
        }
    }
});
