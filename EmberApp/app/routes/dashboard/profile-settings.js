import Ember from 'ember';

export default Ember.Route.extend({
    currentUser: Ember.inject.service('current-user'),

    actions: {
        willTransition(){
            this.get('currentUser.user').rollbackAttributes();
        }
    }
});
