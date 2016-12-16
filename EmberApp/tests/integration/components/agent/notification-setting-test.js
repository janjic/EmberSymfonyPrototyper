import { moduleForComponent, test } from 'ember-qunit';
import hbs from 'htmlbars-inline-precompile';

moduleForComponent('agent/notification-setting', 'Integration | Component | agent/notification setting', {
  integration: true
});

test('it renders', function(assert) {

  // Set any properties with this.set('myProperty', 'value');
  // Handle any actions with this.on('myAction', function(val) { ... });

  this.render(hbs`{{agent/notification-setting}}`);

  assert.equal(this.$().text().trim(), '');

  // Template block usage:
  this.render(hbs`
    {{#agent/notification-setting}}
      template block text
    {{/agent/notification-setting}}
  `);

  assert.equal(this.$().text().trim(), 'template block text');
});
