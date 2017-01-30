import { moduleForComponent, test } from 'ember-qunit';
import hbs from 'htmlbars-inline-precompile';

moduleForComponent('agent-history-suspend', 'Integration | Component | agent history suspend', {
  integration: true
});

test('it renders', function(assert) {

  // Set any properties with this.set('myProperty', 'value');
  // Handle any actions with this.on('myAction', function(val) { ... });

  this.render(hbs`{{agent-history-suspend}}`);

  assert.equal(this.$().text().trim(), '');

  // Template block usage:
  this.render(hbs`
    {{#agent-history-suspend}}
      template block text
    {{/agent-history-suspend}}
  `);

  assert.equal(this.$().text().trim(), 'template block text');
});
