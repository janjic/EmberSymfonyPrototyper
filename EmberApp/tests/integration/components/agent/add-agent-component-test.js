import { moduleForComponent, test } from 'ember-qunit';
import hbs from 'htmlbars-inline-precompile';

moduleForComponent('agent/add-agent-component', 'Integration | Component | agent/add agent component', {
  integration: true
});

test('it renders', function(assert) {
  // Set any properties with this.set('myProperty', 'value');
  // Handle any actions with this.on('myAction', function(val) { ... });

  this.render(hbs`{{agent/add-agent-component}}`);

  assert.equal(this.$().text().trim(), '');

  // Template block usage:
  this.render(hbs`
    {{#agent/add-agent-component}}
      template block text
    {{/agent/add-agent-component}}
  `);

  assert.equal(this.$().text().trim(), 'template block text');
});
