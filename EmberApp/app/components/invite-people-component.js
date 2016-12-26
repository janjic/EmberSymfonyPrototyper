import Ember from 'ember';
import InvitePeopleValidation from '../validations/invite-people';
import LoadingStateMixin from '../mixins/loading-state';
const { inject: { service }, A} = Ember;
const {Translator} = window;

export default Ember.Component.extend(LoadingStateMixin,{
    currentUser:    service('current-user'),
    store:          service('store'),
    validations:    InvitePeopleValidation,
    isModalOpen:    false,

    init() {
        this._setUpDefault();
        this._super(...arguments);
    },

    actions: {
        invitePeople(changeset) {
            if( !this.get('selectedTags').get('length') ){
                this.toast.error(Translator.trans('invitation.email.presence'));
                return;
            }
            if (changeset.validate() && changeset.get('isValid')) {
                let cUser = this.get('currentUser').get('user');
                let recipientsEmails = this.get('selectedTags').map((obj)=>{
                    return obj.email;
                });

                let invitation = this.get('store').createRecord('invitation', {
                    recipientEmail: recipientsEmails,
                    emailSubject:   changeset.get('emailSubject'),
                    emailContent:   changeset.get('emailContent'),
                    agent:          cUser
                });

                this.showLoader('loading.sending.data');
                invitation.save().then(() => {
                    this.toast.success(Translator.trans('invitation.message.save'));
                    this._setUpFields(changeset);
                    this.send('closeModal');
                    }, () => {
                    this.toast.error(Translator.trans('invitation.message.error'));
                });
                this.disableLoader();
            }
        },
        validateProperty(changeset, property) {
            return changeset.validate(property);
        },
        openModal() {
            this.set('isModalOpen', true);
        },
        closeModal(){
            this.set('isModalOpen', false);
        },
        addNew(text) {
            let newTag = {
                id: 1,
                email: text
            };
            if( text.match(/.*@.*\..*/i) ) {
                this.get('items').addObject(newTag);
                this.get('selectedTags').addObject(newTag);
            } else {
                this.toast.error(Translator.trans('invitation.email.invalid'));
            }
        },
        itemChanged(item){
            if( item == null ){
                this.set('selectedTags', Ember.A([]));
            } else if( Ember.A(this.get('selectedTags')).includes(item) ){
                this.send("itemRemoved", item );
            } else {
                this.set('selectedTags', Ember.A(this.get('selectedTags').concat([item])));
            }
        },
        itemRemoved(item){
            let _selected = this.get('selectedTags');
            let i = _selected.indexOf(item);
            let newSelection = _selected.slice(0, i).concat(_selected.slice(i + 1));
            this.set('selectedTags', Ember.A(newSelection));
        }
    },

    _setUpDefault(context=this) {
        this._setUpFields();

        let cUser = this.get('currentUser').get('user');
        let agentEmail = cUser.get('email');
        let agentCode = cUser.get('agentId');
        context.set('agentEmail', agentEmail);
        context.set('agentCode', agentCode);

        context.set('items', A([]));

    },

    _setUpFields(context=this){
        A([
            'emailSubject',
            'emailContent',
        ]).forEach((property) => {
            context.set(property, '');
        });

        this.set('selectedTags', A([]));
    }
});
