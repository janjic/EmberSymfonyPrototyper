import { moduleForComponent, test } from 'ember-qunit';
import hbs from 'htmlbars-inline-precompile';

moduleForComponent('role-changed-modal', 'Integration | Component | role changed modal', {
  integration: true
});

test('it renders', function(assert) {

  // Set any properties with this.set('myProperty', 'value');
  // Handle any actions with this.on('myAction', function(val) { ... });

  this.render(hbs`{{role-changed-modal}}`);

  assert.equal(this.$().text().trim(), '');

  // Template block usage:
  this.render(hbs`
    {{#role-changed-modal}}
      template block text
    {{/role-changed-modal}}
  `);

  assert.equal(this.$().text().trim(), 'template block text');
});
