import Ember from 'ember';
import PermisionCheckerMixin from 'ember-app/mixins/permision-checker';
import { module, test } from 'qunit';

module('Unit | Mixin | permision checker');

// Replace this with your real tests.
test('it works', function(assert) {
  let PermisionCheckerObject = Ember.Object.extend(PermisionCheckerMixin);
  let subject = PermisionCheckerObject.create();
  assert.ok(subject);
});
