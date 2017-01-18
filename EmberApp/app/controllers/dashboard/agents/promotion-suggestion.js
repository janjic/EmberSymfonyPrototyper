import Ember from 'ember';

export default Ember.Controller.extend({
    session : Ember.inject.service('session'),
    page    : 1,
    maxPages: 1,
    offset  : 20,
    init(){

    },
    actions:{
        filterModelPromotions(searchArray, page, column, sortType){
            let ctx = this;
            this.authorizeAjax();
            return Ember.$.ajax({
                type: "POST",
                // url: Routing.generate('agent-promotion-suggestion'),
                url: '/app_dev.php/api/agent-promotion-suggestions',
                data: {
                    type: 'promotion',
                    page: this.get('page'),
                    offset: this.get('offset'),
                    maxPages: this.get('maxPages'),
                    filters: JSON.stringify(searchArray),
                }
            }).then( function(result){
                    return result.promotions;
                    // return new Promise(function (resolve, reject) {
                    //     resolve(result.downgrades);
                    //     reject(result);
                    // });
                }
            );
        },
        filterModelDowngrades(searchArray, page, column, sortType){
            let ctx = this;
            this.authorizeAjax();
            return Ember.$.ajax({
                type: "POST",
                // url: Routing.generate('agent-promotion-suggestion'),
                url: '/app_dev.php/api/agent-promotion-suggestions',
                data: {
                    type: 'downgrade',
                    page: this.get('page'),
                    offset: this.get('offset'),
                    maxPages: this.get('maxPages'),
                    filters: JSON.stringify(searchArray),
                }
            }).then( function(result){
                return result.downgrades;
                    // return new Promise(function (resolve, reject) {
                    //     resolve(result.downgrades);
                    //     reject(result);
                    // });
                }
            );
        },
        searchQuery(page, text, perPage){
            let role = this.get('model.role_codes').role_referee;
            return this.get('store').query('agent', {page:page, rows:perPage, search: text, searchField: 'agent.email', minRoleCondition: role }).then(results => results);
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
    }
});
