import Ember from 'ember';
import InfinityRoute from "ember-infinity/mixins/route";

export default Ember.Route.extend(InfinityRoute, {
    _minId: undefined,
    _maxId: undefined,
    notifications: [],

    model() {
        return this.infinityModel("notification", { perPage: 10, startingPage: 1 }, {
            min_id: '_minId',
        });
    },

    afterInfinityModel(notifications) {
        this.set('_minId', notifications.get('lastObject.id'));
    },

    actions: {
        transitionTo(notification, link, newAgent){
            notification.set('isSeen', true);
            notification.save();

            let agent_id = newAgent.get('id');
            if( link ) {
                if ( agent_id ) {
                    this.transitionTo(link, agent_id );
                } else {
                    this.transitionTo(link);
                }
            }
        }
    }
});
