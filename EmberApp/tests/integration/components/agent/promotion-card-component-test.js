import { moduleForComponent, test } from 'ember-qunit';
import hbs from 'htmlbars-inline-precompile';

moduleForComponent('agent/promotion-card-component', 'Integration | Component | agent/promotion card component', {
  integration: true
});

test('it renders', function(assert) {

  // Set any properties with this.set('myProperty', 'value');
  // Handle any actions with this.on('myAction', function(val) { ... });

  this.render(hbs`{{agent/promotion-card-component}}`);

  assert.equal(this.$().text().trim(), '');

  // Template block usage:
  this.render(hbs`
    {{#agent/promotion-card-component}}
      template block text
    {{/agent/promotion-card-component}}
  `);

  assert.equal(this.$().text().trim(), 'template block text');
});
