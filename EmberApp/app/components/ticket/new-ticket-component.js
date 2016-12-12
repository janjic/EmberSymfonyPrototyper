import Ember from 'ember';

export default Ember.Component.extend({
    store: Ember.inject.service(),
    ticketTypes: ['BUG REPORT', 'WRONG ORDER', 'WRONG INQUIRY'],
    ticketType: 'BUG REPORT',

    actions: {
        chooseDestination(type) {
            this.set('ticketType', type);
        }
    },

    didInsertElement() {
        this._super(...arguments);

    },
});
