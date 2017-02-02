import Ember from 'ember';

export default Ember.Route.extend({
    model(params) {
        return this.store.findRecord('tcrUser', params.id, {reload: true});
    },

    actions: {
        willTransition(){
            console.log('usao');
            this.get('currentModel').rollbackAttributes();
        }
    }
});
