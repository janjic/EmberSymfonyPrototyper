import Ember from 'ember';
import ChangePasswordValidation from '../validations/change-password';
const { inject: { service }, A} = Ember;
const {Routing, ApiCode, Translator} = window;
import LoadingStateMixin from '../mixins/loading-state';
export default Ember.Component.extend(LoadingStateMixin,{
    authorizedAjax: service('authorized-ajax'),
    validations: ChangePasswordValidation,

    init() {
        this._setUpDefault();
        this._super(...arguments);
    },
    actions: {
        setNewPassword(changeset) {
            if (changeset.validate() && changeset.get('isValid')) {
                let options = {
                    oldPassword: changeset.get('oldPassword'),
                    password: changeset.get('password'),
                    passwordConfirmation: changeset.get('passwordConfirmation')
                };
                this.showLoader('loading.sending.data');
                this.get('authorizedAjax').sendAuthorizedRequest(options, 'POST', Routing.generate('api_agent_change_password'),
                    function (response) {
                        switch (parseInt(response.status)) {
                            case ApiCode.OLD_PASSWORD_IS_NOT_CORRECT:
                                this.toast.error(Translator.trans('password.changed.old.is_not_correct'));
                                break;
                            case ApiCode.PASSWORDS_CHANGED_OK:
                                this.set('open', false);
                                this._setUpDefault(changeset);
                                this.toast.success(Translator.trans('password.changed.successfully'));
                                break;
                            case ApiCode.PASSWORDS_ARE_NOT_SAME:
                                this.toast.success(Translator.trans('password.changed.are.not.same'));
                                break;
                            default:
                                return;
                        }
                        this.disableLoader();
                    }.bind(this), this);


            }
        },
        validateProperty(changeset, property) {
            return changeset.validate(property);
        }
    },

    _setUpDefault(context=this) {
        A([
            'password',
            'passwordConfirmation',
            'oldPassword',
        ]).forEach((property) => {
            context.set(property, '');
        });
    }

});
