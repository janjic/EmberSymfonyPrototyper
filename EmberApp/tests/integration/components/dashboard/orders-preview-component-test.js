import { moduleForComponent, test } from 'ember-qunit';
import hbs from 'htmlbars-inline-precompile';

moduleForComponent('dashboard/orders-preview-component', 'Integration | Component | dashboard/orders preview component', {
  integration: true
});

test('it renders', function(assert) {

  // Set any properties with this.set('myProperty', 'value');
  // Handle any actions with this.on('myAction', function(val) { ... });

  this.render(hbs`{{dashboard/orders-preview-component}}`);

  assert.equal(this.$().text().trim(), '');

  // Template block usage:
  this.render(hbs`
    {{#dashboard/orders-preview-component}}
      template block text
    {{/dashboard/orders-preview-component}}
  `);

  assert.equal(this.$().text().trim(), 'template block text');
});