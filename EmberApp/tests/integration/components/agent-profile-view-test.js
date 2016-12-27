import { moduleForComponent, test } from 'ember-qunit';
import hbs from 'htmlbars-inline-precompile';

moduleForComponent('agent-profile-view', 'Integration | Component | agent profile view', {
  integration: true
});

test('it renders', function(assert) {

  // Set any properties with this.set('myProperty', 'value');
  // Handle any actions with this.on('myAction', function(val) { ... });

  this.render(hbs`{{agent-profile-view}}`);

  assert.equal(this.$().text().trim(), '');

  // Template block usage:
  this.render(hbs`
    {{#agent-profile-view}}
      template block text
    {{/agent-profile-view}}
  `);

  assert.equal(this.$().text().trim(), 'template block text');
});
