import Ember from 'ember';
import LoadingStateMixin from '../../mixins/loading-state';
import Changeset from 'ember-changeset';
import lookupValidator from './../../utils/lookupValidator';
import TicketValidations from '../../validations/ticket/add-ticket';
const { service } = Ember.inject;

export default Ember.Component.extend(LoadingStateMixin, {
    TicketValidations,
    store: Ember.inject.service(),
    currentUser: service('current-user'),
    ticketTypes: ['BUG REPORT', 'WRONG ORDER', 'WRONG INQUIRY'],
    ticketType: 'BUG REPORT',
    init(){
        this._super(...arguments);
        this.changeset = new Changeset(this.get('model'), lookupValidator(TicketValidations), TicketValidations);
        this.changeset.set('createdBy', this.get('currentUser.user'));
    },
    actions: {
        chooseType(type) {
            this.set('ticketType', type);
        },
        saveTicket(ticket){
            ticket.set('type', this.ticketType);
            let changeset = this.get('changeset');
            changeset.validate();
            if(changeset.get('isValid')) {
                this.showLoader('loading.sending.data');
                ticket.save().then(() => {
                    this.toast.success(Translator.trans('models.ticket.save.message'));
                    // this.setLoadingText('loading.redirecting');
                    // this.get('goToRoute')('dashboard.agents.all-agents');
                    this.disableLoader();

                }, (response) => {
                    response.errors.forEach((error)=>{
                        switch (parseInt(error.status)) {
                            // case ApiCode.AGENT_ALREADY_EXIST:
                            //     this.toast.error(Translator.trans('models.agent.unique.entity'));
                            //     break;
                            // case ApiCode.FILE_SAVING_ERROR:
                            //     this.toast.error(Translator.trans('models.agent.file.error'));
                            //     break;
                            // case ApiCode.ERROR_MESSAGE:
                            //     this.toast.error(error.message);
                            //     break;
                            // default:
                            //     return;
                        }
                        this.disableLoader();
                    });
                });
            }

        },
        /** validations */
        reset(changeset) {
            return changeset.rollback();
        },
        validateProperty(changeset, property) {
            return changeset.validate(property);
        },
    },
});
