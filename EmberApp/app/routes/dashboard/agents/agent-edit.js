import Ember from 'ember';
import RSVP from 'rsvp';
import {withoutProxies} from './../../../utils/proxy-helpers';
export default Ember.Route.extend({
    model: function (params) {
        //We must create new address, because change set constructors needs object
        let agent = new RSVP.Promise((resolve)=> {
             this.store.findRecord('agent', params.id,  { backgroundReload: true }).then((agent)=> {
                if (!withoutProxies(agent.get('address'))) {
                    let address = this.store.createRecord('address');
                    agent.set('address', address);
                }
                resolve(agent);
            });

        });
        let promises = {
            agent,
            groups:  this.get('store').findAll('group')
        };
        return RSVP.hash(promises);
    }
});
