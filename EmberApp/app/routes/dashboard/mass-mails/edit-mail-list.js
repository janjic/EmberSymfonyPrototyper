import Ember from 'ember';

export default Ember.Route.extend({
    model: function (params) {
        return this.store.findRecord('mail-list', params.id, {reload: true});
    },

    actions: {
        willTransition(){
            this.get('currentModel').rollbackAttributes();
        }
    }
});
