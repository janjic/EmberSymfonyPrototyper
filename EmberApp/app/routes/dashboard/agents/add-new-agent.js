import Ember from 'ember';

export default Ember.Route.extend({
    model: function () {
        let agent = this.store.createRecord('agent');
        return agent;
    }
});
