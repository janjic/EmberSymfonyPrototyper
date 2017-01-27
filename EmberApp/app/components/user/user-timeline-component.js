import Ember from 'ember';

export default Ember.Component.extend({
    user: Ember.computed('model', function () {
        if(this.get('model')){
            return this.get('model').objectAt(0).get('agent');
        }
    })
});
