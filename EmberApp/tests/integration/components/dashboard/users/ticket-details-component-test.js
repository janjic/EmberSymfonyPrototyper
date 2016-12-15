import { moduleForComponent, test } from 'ember-qunit';
import hbs from 'htmlbars-inline-precompile';

moduleForComponent('dashboard/users/ticket-details-component', 'Integration | Component | dashboard/users/ticket details component', {
  integration: true
});

test('it renders', function(assert) {

  // Set any properties with this.set('myProperty', 'value');
  // Handle any actions with this.on('myAction', function(val) { ... });

  this.render(hbs`{{dashboard/users/ticket-details-component}}`);

  assert.equal(this.$().text().trim(), '');

  // Template block usage:
  this.render(hbs`
    {{#dashboard/users/ticket-details-component}}
      template block text
    {{/dashboard/users/ticket-details-component}}
  `);

  assert.equal(this.$().text().trim(), 'template block text');
});
