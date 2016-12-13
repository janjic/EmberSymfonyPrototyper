import { moduleForComponent, test } from 'ember-qunit';
import hbs from 'htmlbars-inline-precompile';

moduleForComponent('ticket/new-ticket-component', 'Integration | Component | ticket/new ticket component', {
  integration: true
});

test('it renders', function(assert) {

  // Set any properties with this.set('myProperty', 'value');
  // Handle any actions with this.on('myAction', function(val) { ... });

  this.render(hbs`{{ticket/new-ticket-component}}`);

  assert.equal(this.$().text().trim(), '');

  // Template block usage:
  this.render(hbs`
    {{#ticket/new-ticket-component}}
      template block text
    {{/ticket/new-ticket-component}}
  `);

  assert.equal(this.$().text().trim(), 'template block text');
});
