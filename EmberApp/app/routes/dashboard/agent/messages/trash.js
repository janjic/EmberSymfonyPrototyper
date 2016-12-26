import Ember from 'ember';
import InfinityRoute from "ember-infinity/mixins/route";

export default Ember.Route.extend(InfinityRoute, {
    model() {
        return this.infinityModel("thread", { perPage: 10, startingPage: 1, type: 'deleted' });
    },

    deactivate: function() {
        this.controllerFor('dashboard.agent.messages.trash').set('selectedThread', null);
    }
});
