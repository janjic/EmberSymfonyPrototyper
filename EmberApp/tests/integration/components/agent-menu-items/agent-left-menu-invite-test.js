import { moduleForComponent, test } from 'ember-qunit';
import hbs from 'htmlbars-inline-precompile';

moduleForComponent('agent-menu-items/agent-left-menu-invite', 'Integration | Component | agent menu items/agent left menu invite', {
  integration: true
});

test('it renders', function(assert) {

  // Set any properties with this.set('myProperty', 'value');
  // Handle any actions with this.on('myAction', function(val) { ... });

  this.render(hbs`{{agent-menu-items/agent-left-menu-invite}}`);

  assert.equal(this.$().text().trim(), '');

  // Template block usage:
  this.render(hbs`
    {{#agent-menu-items/agent-left-menu-invite}}
      template block text
    {{/agent-menu-items/agent-left-menu-invite}}
  `);

  assert.equal(this.$().text().trim(), 'template block text');
});
