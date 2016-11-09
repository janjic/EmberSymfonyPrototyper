import Ember from 'ember';
import ValidationMixin from 'ember-app/mixins/validation';
import { module, test } from 'qunit';

module('Unit | Mixin | validation');

// Replace this with your real tests.
test('it works', function(assert) {
  let ValidationObject = Ember.Object.extend(ValidationMixin);
  let subject = ValidationObject.create();
  assert.ok(subject);
});
