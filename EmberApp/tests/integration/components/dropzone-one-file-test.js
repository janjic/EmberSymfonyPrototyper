import { moduleForComponent, test } from 'ember-qunit';
import hbs from 'htmlbars-inline-precompile';

moduleForComponent('dropzone-one-file', 'Integration | Component | dropzone one file', {
  integration: true
});

test('it renders', function(assert) {

  // Set any properties with this.set('myProperty', 'value');
  // Handle any actions with this.on('myAction', function(val) { ... });

  this.render(hbs`{{dropzone-one-file}}`);

  assert.equal(this.$().text().trim(), '');

  // Template block usage:
  this.render(hbs`
    {{#dropzone-one-file}}
      template block text
    {{/dropzone-one-file}}
  `);

  assert.equal(this.$().text().trim(), 'template block text');
});
