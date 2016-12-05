import { moduleForComponent, test } from 'ember-qunit';
import hbs from 'htmlbars-inline-precompile';

moduleForComponent('draggable-file-uploaded', 'Integration | Component | draggable file uploaded', {
  integration: true
});

test('it renders', function(assert) {
  // Set any properties with this.set('myProperty', 'value');
  // Handle any actions with this.on('myAction', function(val) { ... });

  this.render(hbs`{{draggable-file-uploaded}}`);

  assert.equal(this.$().text().trim(), '');

  // Template block usage:
  this.render(hbs`
    {{#draggable-file-uploaded}}
      template block text
    {{/draggable-file-uploaded}}
  `);

  assert.equal(this.$().text().trim(), 'template block text');
});
