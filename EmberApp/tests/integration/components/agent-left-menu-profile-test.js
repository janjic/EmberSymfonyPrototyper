import { moduleForComponent, test } from 'ember-qunit';
import hbs from 'htmlbars-inline-precompile';

moduleForComponent('agent-left-menu-profile', 'Integration | Component | agent left menu profile', {
  integration: true
});

test('it renders', function(assert) {
  // Set any properties with this.set('myProperty', 'value');
  // Handle any actions with this.on('myAction', function(val) { ... });

  this.render(hbs`{{agent-left-menu-profile}}`);

  assert.equal(this.$().text().trim(), '');

  // Template block usage:
  this.render(hbs`
    {{#agent-left-menu-profile}}
      template block text
    {{/agent-left-menu-profile}}
  `);

  assert.equal(this.$().text().trim(), 'template block text');
});
