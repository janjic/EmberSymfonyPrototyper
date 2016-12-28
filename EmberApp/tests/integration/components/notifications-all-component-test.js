import { moduleForComponent, test } from 'ember-qunit';
import hbs from 'htmlbars-inline-precompile';

moduleForComponent('notifications-all-component', 'Integration | Component | notifications all component', {
  integration: true
});

test('it renders', function(assert) {

  // Set any properties with this.set('myProperty', 'value');
  // Handle any actions with this.on('myAction', function(val) { ... });

  this.render(hbs`{{notifications-all-component}}`);

  assert.equal(this.$().text().trim(), '');

  // Template block usage:
  this.render(hbs`
    {{#notifications-all-component}}
      template block text
    {{/notifications-all-component}}
  `);

  assert.equal(this.$().text().trim(), 'template block text');
});
