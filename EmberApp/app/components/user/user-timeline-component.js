import Ember from 'ember';

export default Ember.Component.extend({
    hasResults: Ember.computed('model', function () {
        return this.get('model.length')!== 0;
    })
});
