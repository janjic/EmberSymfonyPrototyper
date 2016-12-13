import Ember from 'ember';
import InvitePeopleValidation from '../validations/invite-people';
const { inject: { service }, A} = Ember;
import LoadingStateMixin from '../mixins/loading-state';

export default Ember.Component.extend(LoadingStateMixin,{
    currentUser: service('current-user'),
    store:       service('store'),
    validations: InvitePeopleValidation,
    isModalOpen: false,

    init() {
        this._setUpDefault();
        this._super(...arguments);
    },

    actions: {
        invitePeople(changeset) {
            if (changeset.validate() && changeset.get('isValid')) {
                let cUser = this.get('currentUser').get('user');
                let invitation = this.get('store').createRecord('invitation', {
                    recipientEmail: changeset.get('recipientEmail').split(';'),
                    emailSubject:   changeset.get('emailSubject'),
                    emailContent:   'content',
                    agent:          cUser
                });

                this.showLoader('loading.sending.data');
                invitation.save().then(() => {
                    this.toast.success('uspesno');
                    this.set('isModalOpen', false);
                    }, () => {
                    this.toast.error('neuspesno');
                    this.disableLoader();
                });
            }
        },
        validateProperty(changeset, property) {
            return changeset.validate(property);
        },
        openModal() {
            this.set('isModalOpen', true);
        }
    },

    _setUpDefault(context=this) {
        A([
            'recipientEmail',
            'emailSubject',
            'emailContent',
        ]).forEach((property) => {
            context.set(property, '');
        });

        let cUser = this.get('currentUser').get('user');
        let agentEmail = cUser.get('email');
        let agentCode = cUser.get('id');
        context.set('agentEmail', agentEmail);
        context.set('agentCode', agentCode);
    }
});
