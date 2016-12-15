import Ember from 'ember';
import LoadingStateMixin from '../../mixins/loading-state';
import Changeset from 'ember-changeset';
import lookupValidator from './../../utils/lookupValidator';
import TicketValidations from '../../validations/ticket/add-ticket';
const { service } = Ember.inject;
const {ApiCode, Translator} = window;

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
            console.log(ticket.get('file.name'));
            if(changeset.get('isValid')) {
                this.showLoader('loading.sending.data');
                ticket.save().then(() => {
                    this.toast.success(Translator.trans('models.ticket.save.message'));
                    this.disableLoader();

                }, (response) => {
                    response.errors.forEach((error)=>{
                        switch (parseInt(error.status)) {
                            case ApiCode.FILE_SAVING_ERROR:
                                this.toast.error(Translator.trans('models.agent.file.error'));
                                break;
                            case ApiCode.ERROR_MESSAGE:
                                this.toast.error(Translator.trans(error.message));
                                break;
                            default:
                                return;
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
        addedFile (file) {
            this.set('model.file.name', file.name);
            let reader = new FileReader();
            let $this = this;
            reader.onloadend = function () {
                let fileBase64 = reader.result;
                $this.set('model.file.base64Content', fileBase64);
            };
            reader.readAsDataURL(file);
        },
        removedFile() {
            this.set('model.file.name', null);
            this.set('model.file.base64Content', null);
        },
    },
});
