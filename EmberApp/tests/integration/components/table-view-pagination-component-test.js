import { moduleForComponent, test } from 'ember-qunit';
import hbs from 'htmlbars-inline-precompile';

moduleForComponent('table-view-pagination-component', 'Integration | Component | table view pagination component', {
  integration: true
});

test('it renders', function(assert) {

  // Set any properties with this.set('myProperty', 'value');
  // Handle any actions with this.on('myAction', function(val) { ... });

  this.render(hbs`{{table-view-pagination-component}}`);

  assert.equal(this.$().text().trim(), '');

  // Template block usage:
  this.render(hbs`
    {{#table-view-pagination-component}}
      template block text
    {{/table-view-pagination-component}}
  `);

  assert.equal(this.$().text().trim(), 'template block text');
});
