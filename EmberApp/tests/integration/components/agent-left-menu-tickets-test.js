import { moduleForComponent, test } from 'ember-qunit';
import hbs from 'htmlbars-inline-precompile';

moduleForComponent('agent-left-menu-tickets', 'Integration | Component | agent left menu tickets', {
  integration: true
});

test('it renders', function(assert) {
  // Set any properties with this.set('myProperty', 'value');
  // Handle any actions with this.on('myAction', function(val) { ... });

  this.render(hbs`{{agent-left-menu-tickets}}`);

  assert.equal(this.$().text().trim(), '');

  // Template block usage:
  this.render(hbs`
    {{#agent-left-menu-tickets}}
      template block text
    {{/agent-left-menu-tickets}}
  `);

  assert.equal(this.$().text().trim(), 'template block text');
});
