import Ember from 'ember';
import InvitePeopleValidation from '../validations/invite-people';
import LoadingStateMixin from '../mixins/loading-state';
const { inject: { service }, A} = Ember;
const {Translator} = window;

export default Ember.Component.extend(LoadingStateMixin,{
    currentUser:    service('current-user'),
    store:          service(),
    validations:    InvitePeopleValidation,
    isModalOpen:    false,

    init() {
        this._setUpDefault();
        this._super(...arguments);
        this.set('mailLists', []);
    },
    didInsertElement(){
        let ctx = this;
        this.get('store').findAll('mail-list', {reload: true}).then((lists)=> {
            lists.forEach(function (item) {
                if(item.get('id')){
                    ctx.get('mailLists').pushObject(item);
                }
            });
        });
    },
    validateList(list){
        if(list.get('id')){
            this.get('mailLists').pushObject(list);
        }
    },

    actions: {
        invitePeople() {
            if( !this.get('mailList')){
                this.toast.error(Translator.trans('invitation.mail.list.invalid'));
                return;
            }
            let cUser = this.get('currentUser').get('user');


            let invitation = this.get('sendInvites')(
                cUser,
                this.get('mailList.id')
            );

            this.showLoader('loading.sending.data');
            invitation.save().then(() => {
                this.toast.success(Translator.trans('invitation.message.save'));
                this.set('mailList', null);
                this.send('closeModal');
            }, () => {
                this.toast.error(Translator.trans('invitation.message.error'));
            });
            this.disableLoader();
        },
        goToAddList(){
            this.send('closeModal');
            if(this.get('currentUser.isUserAdmin')){
                this.get('goToRoute')('dashboard.mass-mails.add-new-mail-list');
            } else {
                this.get('goToRoute')('dashboard.agent.invite-people.new-mail-list');
            }
        },
        openModal() {
            this.set('isModalOpen', true);
        },
        closeModal(){
            this.set('isModalOpen', false);
        },
        changeList(list){
            this.set('mailList', list);
        }
    },

    _setUpDefault(context=this) {
        let cUser = this.get('currentUser').get('user');
        let agentEmail = cUser.get('email');
        let agentCode = cUser.get('agentId');
        context.set('agentEmail', agentEmail);
        context.set('agentCode', agentCode);
        context.set('items', A([]));

    }
});
