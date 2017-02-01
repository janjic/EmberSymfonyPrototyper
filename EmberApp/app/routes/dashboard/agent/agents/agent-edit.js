import Ember from 'ember';
import RSVP from 'rsvp';
import {withoutProxies} from './../../../../utils/proxy-helpers';
export default Ember.Route.extend({
    currentUser: Ember.inject.service('current-user'),
    model: function (params) {
        //We must create new address, because change set constructors needs object
        let agent = new RSVP.Promise((resolve, reject)=> {
            this.store.findRecord('agent', params.id,  { backgroundReload: true }).then((agent)=> {
                if (!withoutProxies(agent.get('address'))) {
                    let address = this.store.createRecord('address');
                    agent.set('address', address);
                }
                resolve(agent);
            }, (reason)=>{
                reject(reason);
            });

        });
        let promises = {
            agent,
            groups:  this.get('store').findAll('group')
        };
        return RSVP.hash(promises);
    },

    actions: {
        error: function(reason) {
            if (reason && reason.errors[0] && reason.errors[0].status === 403) {
                this.toast.error('general.not-allowed');
                this.transitionTo('dashboard.agent.agents.all-agents');
            } else {
                return true; // throw exception
            }
        },
    },

    afterModel(model) {
        if (Object.is(model.agent.get('id'), this.get('currentUser.user.id'))) {
            this.transitionTo('dashboard.agent.profile.profile-settings');
        }
    }


});
