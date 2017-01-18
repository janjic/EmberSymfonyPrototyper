import Ember from 'ember';
import { task, timeout } from 'ember-concurrency';

export default Ember.Component.extend({
    session     : Ember.inject.service('session'),
    isModalOpen : false,
    actions:{
        promote(agent){
            if(agent.role_code == this.get('role_codes').role_referee){
                this.set('isModalOpen', true);
            }
            let data = {
                agent_id : agent.agent_id,
                role     : agent.role_code,
                action   : "promote"
            };
            Ember.$.ajax({
                type: "POST",
                // url: Routing.generate('promote-agent'),
                url: '/app_dev.php/api/promote-agent',
                data: data
            }).then( function(result){
                    console.log(result);
                }
            );
        },
        agentSelected(agent){
            console.log(agent);
        }
    },
    authorizeAjax(){
        /** set access token to ajax requests sent by orgchart library */
        let accessToken = `Bearer ${this.get('session.data.authenticated.access_token')}`;

        Ember.$.ajaxSetup({
            beforeSend: (xhr) => {
                accessToken = `Bearer ${this.get('session.data.authenticated.access_token')}`;
                xhr.setRequestHeader('Authorization', accessToken);
            },
            headers: { 'Authorization': accessToken }
        });
    },
    search: task(function * (text, page, perPage) {
        yield timeout(200);
        return this.get('searchQuery')(page, text, perPage);
    }),
});
