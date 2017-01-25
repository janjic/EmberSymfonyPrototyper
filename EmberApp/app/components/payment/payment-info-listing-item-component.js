import Ember from 'ember';
import LoadingStateMixin from '../../mixins/loading-state';
const {Routing, ApiCode, Translator} = window;

export default Ember.Component.extend(LoadingStateMixin, {
    authorizedAjax: Ember.inject.service('authorized-ajax'),

    isEditing: true,

    init() {
        this._super(...arguments);
        this.set('newMemo', this.get('payment.memo'));
    },

    actions: {
        // toggleEditing: function() {
            // this.toggleProperty('isEditing');
        // },

        saveEdit: function() {
            this.showLoader();
            this.set('payment.memo', this.get('newMemo'));
            this.get('payment').save().then(()=>{
                this.disableLoader();
                // this.toggleProperty('isEditing');
                this.toast.success('models.payment-info.memo-updated');
            }, ()=>{
                this.disableLoader();
                this.get('payment').rollbackAttributes();
                this.toast.error('models.payment-info.memo-update-fail');
            });
        },

        cancelEdit: function() {
            this.set('newMemo', this.get('payment.memo'));
            // this.get('payment').rollbackAttributes();
            // this.toggleProperty('isEditing');
        },

        processPayment: function (payment) {
            this.processPaymentStateChange(payment, true);
        },

        rejectPayment: function (payment) {
            this.processPaymentStateChange(payment, false);
        }
    },

    processPaymentStateChange: function (payment, newState) {
        let options = {
            paymentId: payment.get('id'),
            newState: newState
        };

        this.get('authorizedAjax').sendAuthorizedRequest(options, 'POST', Routing.generate('api_execute_payment'), function (response) {
            switch (parseInt(response.meta.status)) {
                case ApiCode.PAYMENT_EXECUTE_ERROR:
                    if (newState) {
                        this.toast.success(Translator.trans('models.payment-info.pay-error'));
                    } else {
                        this.toast.success(Translator.trans('models.payment-info.reject-error'));
                    }
                    break;
                case ApiCode.PAYMENT_EXECUTED_SUCCESSFULLY:
                    payment.set('state', newState ? 'true' : 'false');
                    if (newState) {
                        this.toast.success(Translator.trans('models.payment-info.pay-success'));
                    } else {
                        this.toast.success(Translator.trans('models.payment-info.reject-success'));
                    }
                    break;
                default:
                    return;
            }
        }.bind(this), this);
    },
});
