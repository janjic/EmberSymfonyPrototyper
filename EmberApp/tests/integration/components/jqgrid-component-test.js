import { moduleForComponent, test } from 'ember-qunit';
import hbs from 'htmlbars-inline-precompile';

moduleForComponent('jqgrid-component', 'Integration | Component | jqgrid component', {
  integration: true
});

test('it renders', function(assert) {
  // Set any properties with this.set('myProperty', 'value');
  // Handle any actions with this.on('myAction', function(val) { ... });

  this.render(hbs`{{jqgrid-component}}`);

  assert.equal(this.$().text().trim(), '');

  // Template block usage:
  this.render(hbs`
    {{#jqgrid-component}}
      template block text
    {{/jqgrid-component}}
  `);

  assert.equal(this.$().text().trim(), 'template block text');
});
