import { moduleForComponent, test } from 'ember-qunit';
import hbs from 'htmlbars-inline-precompile';

moduleForComponent('agent/edit-agent-component', 'Integration | Component | agent/edit agent component', {
  integration: true
});

test('it renders', function(assert) {
  // Set any properties with this.set('myProperty', 'value');
  // Handle any actions with this.on('myAction', function(val) { ... });

  this.render(hbs`{{agent/edit-agent-component}}`);

  assert.equal(this.$().text().trim(), '');

  // Template block usage:
  this.render(hbs`
    {{#agent/edit-agent-component}}
      template block text
    {{/agent/edit-agent-component}}
  `);

  assert.equal(this.$().text().trim(), 'template block text');
});
