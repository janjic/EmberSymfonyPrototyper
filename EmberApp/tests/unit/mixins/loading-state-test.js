import Ember from 'ember';
import LoadingStateMixin from 'ember-app/mixins/loading-state';
import { module, test } from 'qunit';

module('Unit | Mixin | loading state');

// Replace this with your real tests.
test('it works', function(assert) {
  let LoadingStateObject = Ember.Object.extend(LoadingStateMixin);
  let subject = LoadingStateObject.create();
  assert.ok(subject);
});
