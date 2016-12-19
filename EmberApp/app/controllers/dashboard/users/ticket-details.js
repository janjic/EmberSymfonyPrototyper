import Ember from 'ember';
const { service } = Ember.inject;
import TicketControllerActionsMixin from './../../../mixins/ticket-controller-actions';
const { assign } = Ember;
export default Ember.Controller.extend(TicketControllerActionsMixin, {
    currentUser: service('current-user'),
    actions: assign({}, this.actions, {
        search (page, text, perPage) {
            return this.get('store').query('agent', {page:page, rows:perPage, search: text, searchField: 'agent.email'}).then(results => results);
        }
    })
});
