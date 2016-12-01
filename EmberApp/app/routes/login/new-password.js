import Ember from 'ember';

export default Ember.Route.extend({
    model(params) {
        this.set('token', params.token);
        this._super(...arguments);
    },

    setupController(controller) {
        controller.set('token', this.get('token'));
        this._super(...arguments);
    }
});
