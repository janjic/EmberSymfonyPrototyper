import { moduleForComponent, test } from 'ember-qunit';
import hbs from 'htmlbars-inline-precompile';

moduleForComponent('profile-view-agents-component', 'Integration | Component | profile view agents component', {
  integration: true
});

test('it renders', function(assert) {

  // Set any properties with this.set('myProperty', 'value');
  // Handle any actions with this.on('myAction', function(val) { ... });

  this.render(hbs`{{profile-view-agents-component}}`);

  assert.equal(this.$().text().trim(), '');

  // Template block usage:
  this.render(hbs`
    {{#profile-view-agents-component}}
      template block text
    {{/profile-view-agents-component}}
  `);

  assert.equal(this.$().text().trim(), 'template block text');
});
