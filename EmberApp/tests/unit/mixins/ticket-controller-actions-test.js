import Ember from 'ember';
import TicketControllerActionsMixin from 'ember-app/mixins/ticket-controller-actions';
import { module, test } from 'qunit';

module('Unit | Mixin | ticket controller actions');

// Replace this with your real tests.
test('it works', function(assert) {
  let TicketControllerActionsObject = Ember.Object.extend(TicketControllerActionsMixin);
  let subject = TicketControllerActionsObject.create();
  assert.ok(subject);
});
