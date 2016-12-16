import Ember from 'ember';
const { service } = Ember.inject;
import TicketControllerActionsMixin from './../../../../mixins/ticket-controller-actions';

export default Ember.Controller.extend(TicketControllerActionsMixin, {
    currentUser: service('current-user'),

});
