import Ember from 'ember';
import InfinityRoute from "ember-infinity/mixins/route";

export default Ember.Route.extend(InfinityRoute, {
    _minId: undefined,
    _maxId: undefined,
    notifications: [],

    model() {
        return this.infinityModel("notification", { perPage: 10, startingPage: 1, type: 'NEW AGENT/PAYMENT NOTIFICATION' }, {
            min_id: '_minId',
        });
    },

    afterInfinityModel(notifications) {
        this.set('_minId', notifications.get('lastObject.id'));
    },

    actions: {
        transitionTo(notification, link){
            notification.set('isSeen', true);
            notification.save();

            if ( notification.get('newAgent.id') ){
                this.transitionTo(link, notification.get('newAgent.id'));
            } else {
                this.transitionTo(link);
            }
        }
    },

    beforeModel(){
        this.set('_minId', undefined);
        this.set('_maxId', undefined);
    }
});
