import { moduleForComponent, test } from 'ember-qunit';
import hbs from 'htmlbars-inline-precompile';

moduleForComponent('letter-btn', 'Integration | Component | letter btn', {
  integration: true
});

test('it renders', function(assert) {

  // Set any properties with this.set('myProperty', 'value');
  // Handle any actions with this.on('myAction', function(val) { ... });

  this.render(hbs`{{letter-btn}}`);

  assert.equal(this.$().text().trim(), '');

  // Template block usage:
  this.render(hbs`
    {{#letter-btn}}
      template block text
    {{/letter-btn}}
  `);

  assert.equal(this.$().text().trim(), 'template block text');
});
