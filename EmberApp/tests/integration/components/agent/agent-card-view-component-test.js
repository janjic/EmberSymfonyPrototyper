import { moduleForComponent, test } from 'ember-qunit';
import hbs from 'htmlbars-inline-precompile';

moduleForComponent('agent/agent-card-view-component', 'Integration | Component | agent/agent card view component', {
  integration: true
});

test('it renders', function(assert) {

  // Set any properties with this.set('myProperty', 'value');
  // Handle any actions with this.on('myAction', function(val) { ... });

  this.render(hbs`{{agent/agent-card-view-component}}`);

  assert.equal(this.$().text().trim(), '');

  // Template block usage:
  this.render(hbs`
    {{#agent/agent-card-view-component}}
      template block text
    {{/agent/agent-card-view-component}}
  `);

  assert.equal(this.$().text().trim(), 'template block text');
});
