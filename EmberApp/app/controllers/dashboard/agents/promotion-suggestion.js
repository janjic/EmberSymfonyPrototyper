import Ember from 'ember';
import RSVP from 'rsvp';
const {Routing} = window;

export default Ember.Controller.extend({
    authorizedAjax : Ember.inject.service('authorized-ajax'),
    page    : 1,
    offset  : 4,
    groups  : [],
    actions:{
        filterModelPromotions(searchArray, page, maxPages){
            let data =  {
                type: 'promotion',
                    page: page,
                    offset: this.get('offset'),
                    maxPages: maxPages,
                    filters: JSON.stringify(searchArray),
            };

            return new RSVP.Promise((resolve) =>{
                this.get('authorizedAjax').sendAuthorizedRequest(data, 'POST', 'app_dev.php'+Routing.generate('agent-promotion-suggestion'),
                    function (response) {
                        resolve(response.promotions);
                    }.bind(this));
            });

        },
        filterModelDowngrades(searchArray, page, maxPages){
            let data =  {
                type: 'downgrade',
                page: page,
                offset: this.get('offset'),
                maxPages: maxPages,
                filters: JSON.stringify(searchArray),
            };

            return new RSVP.Promise((resolve) =>{
                this.get('authorizedAjax').sendAuthorizedRequest(data, 'POST', 'app_dev.php'+Routing.generate('agent-promotion-suggestion'),
                    function (response) {
                        resolve(response.downgrades);
                    }.bind(this));
            });

        },
        searchQuery(page, text, perPage){
            let role = this.get('model.role_codes').role_referee;
            return this.get('store').query('agent', {page:page, rows:perPage, search: text, searchField: 'agent.email', minRoleCondition: role }).then(results => results);
        },
        removePromotion(agentId)
        {
            let promotions = this.get('model.promotions.data');
            promotions.forEach(function(item, index){
                if(item.agent_id === agentId) {
                    promotions.removeAt(index);
                }
            });

            return new RSVP.Promise(() =>{
                this.get('authorizedAjax').sendAuthorizedRequest(null, 'GET', 'app_dev.php'+Routing.generate('agent-promotion-suggestion'),
                    function (response) {
                    console.log(response);
                    this.set('model', response);
                    }.bind(this));
            });

        },
        removeDemotion(agentId)
        {
            let downgrades = this.get('model.downgrades.data');
            downgrades.forEach(function(item, index){
                if(item.agent_id === agentId) {
                    downgrades.removeAt(index);
                }
            });

            return new RSVP.Promise(() =>{
                this.get('authorizedAjax').sendAuthorizedRequest(null, 'GET', 'app_dev.php'+Routing.generate('agent-promotion-suggestion'),
                    function (response) {
                        console.log(response);
                        this.set('model', response);
                    }.bind(this));
            });

        }
    },
});
