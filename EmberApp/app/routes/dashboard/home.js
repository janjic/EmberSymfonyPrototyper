import Ember from 'ember';

export default Ember.Route.extend({
    setupController : function(controller/*, model*/){
        this._super(...arguments);
        controller.set('newAgentsLoading', true);
        controller.set('newUsersInfoLoading', true);
        controller.set('newOrdersInfoLoading', true);
        controller.set('newCommissionsInfoLoading', true);
        controller.set('newMessagesInfoLoading', true);
    }
});
