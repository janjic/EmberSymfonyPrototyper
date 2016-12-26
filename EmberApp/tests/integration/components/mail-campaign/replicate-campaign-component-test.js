import { moduleForComponent, test } from 'ember-qunit';
import hbs from 'htmlbars-inline-precompile';

moduleForComponent('mail-campaign/replicate-campaign-component', 'Integration | Component | mail campaign/replicate campaign component', {
  integration: true
});

test('it renders', function(assert) {

  // Set any properties with this.set('myProperty', 'value');
  // Handle any actions with this.on('myAction', function(val) { ... });

  this.render(hbs`{{mail-campaign/replicate-campaign-component}}`);

  assert.equal(this.$().text().trim(), '');

  // Template block usage:
  this.render(hbs`
    {{#mail-campaign/replicate-campaign-component}}
      template block text
    {{/mail-campaign/replicate-campaign-component}}
  `);

  assert.equal(this.$().text().trim(), 'template block text');
});
