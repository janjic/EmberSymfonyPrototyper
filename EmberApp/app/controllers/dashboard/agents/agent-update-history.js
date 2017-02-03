import Ember from 'ember';
const Translator = window.Translator;
import { task, timeout } from 'ember-concurrency';

export default Ember.Controller.extend({
    actions: {
        agentSelected(agent){
            if(agent !== null){
                this.set('isLoading', true);
                this.get('store').findRecord('agent', agent.get('id'), { reload : true }).then((agent)=>{
                    this.store.query('agent-history', { agentId: agent.get('id')}, { reload : true }).then((history)=>{
                        this.set('agentHistory',history);
                        this.set('currentAgent', agent);
                        this.set('isLoading', false);
                    });
                });
            } else {
                this.set('currentAgent', null);
                this.set('agentHistory', []);
            }

        },
    },
    search: task(function * (text, page, perPage) {
        yield timeout(200);
        return this.get('store').query('agent', {page:page, rows:perPage, search: text, searchField: 'agent.email'}).then(results => results);
    }),

});
