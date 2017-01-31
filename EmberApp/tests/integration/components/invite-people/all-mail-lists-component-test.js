import { moduleForComponent, test } from 'ember-qunit';
import hbs from 'htmlbars-inline-precompile';

moduleForComponent('invite-people/all-mail-lists-component', 'Integration | Component | invite people/all mail lists component', {
  integration: true
});

test('it renders', function(assert) {

  // Set any properties with this.set('myProperty', 'value');
  // Handle any actions with this.on('myAction', function(val) { ... });

  this.render(hbs`{{invite-people/all-mail-lists-component}}`);

  assert.equal(this.$().text().trim(), '');

  // Template block usage:
  this.render(hbs`
    {{#invite-people/all-mail-lists-component}}
      template block text
    {{/invite-people/all-mail-lists-component}}
  `);

  assert.equal(this.$().text().trim(), 'template block text');
});
