import Ember from 'ember';
import PermissionCheckerMixin from 'ember-app/mixins/permission-checker';
import { module, test } from 'qunit';

module('Unit | Mixin | permission checker');

// Replace this with your real tests.
test('it works', function(assert) {
  let PermissionCheckerObject = Ember.Object.extend(PermissionCheckerMixin);
  let subject = PermissionCheckerObject.create();
  assert.ok(subject);
});
