import { moduleForComponent, test } from 'ember-qunit';
import hbs from 'htmlbars-inline-precompile';

moduleForComponent('agent-menu-items/agent-left-menu-agents', 'Integration | Component | agent menu items/agent left menu agents', {
  integration: true
});

test('it renders', function(assert) {

  // Set any properties with this.set('myProperty', 'value');
  // Handle any actions with this.on('myAction', function(val) { ... });

  this.render(hbs`{{agent-menu-items/agent-left-menu-agents}}`);

  assert.equal(this.$().text().trim(), '');

  // Template block usage:
  this.render(hbs`
    {{#agent-menu-items/agent-left-menu-agents}}
      template block text
    {{/agent-menu-items/agent-left-menu-agents}}
  `);

  assert.equal(this.$().text().trim(), 'template block text');
});
