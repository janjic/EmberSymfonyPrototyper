import Ember from 'ember';

export default Ember.Route.extend({
    model() {
        let ticket = this.store.createRecord('ticket');
        let file = this.store.createRecord('file');
        ticket.set('file', file);
        return ticket;

    }
});
