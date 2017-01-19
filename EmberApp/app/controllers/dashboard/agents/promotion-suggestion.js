import Ember from 'ember';
import RSVP from 'rsvp';
const {Routing} = window;

export default Ember.Controller.extend({
    authorizedAjax : Ember.inject.service('authorized-ajax'),
    page    : 1,
    maxPages: 1,
    offset  : 20,
    actions:{
        filterModelPromotions(searchArray, page){
            let data =  {
                type: 'promotion',
                    page: page,
                    offset: this.get('offset'),
                    maxPages: this.get('maxPages'),
                    filters: JSON.stringify(searchArray),
            };

            return new RSVP.Promise((resolve) =>{
                this.get('authorizedAjax').sendAuthorizedRequest(data, 'POST', 'app_dev.php'+Routing.generate('agent-promotion-suggestion'),
                    function (response) {
                        resolve(response.promotions);
                    }.bind(this));
            });

        },
        filterModelDowngrades(searchArray, page){
            let data =  {
                type: 'downgrade',
                page: page,
                offset: this.get('offset'),
                maxPages: this.get('maxPages'),
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
        }
    },
});
