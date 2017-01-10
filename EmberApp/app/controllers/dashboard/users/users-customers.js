import Ember from 'ember';
import { task, timeout } from 'ember-concurrency';

export default Ember.Controller.extend({
    page: 1,
    offset: 8,
    promoCode: undefined,
    searchArray: undefined,
    colNames: ['ID', 'First Name', 'Last Name', ' Username', 'Enabled', 'Country', 'Actions'],
    colModels: [
        {value: 'id', compare:'cn'},
        {value: 'firstName', compare:'cn'},
        {value: 'lastName', compare:'cn'},
        {value: 'username', compare:'cn'},
        {value: 'enabled', compare:'eq', compareValues: [{name: 'true', value:'1'},{name: 'false', value:'0'}]},
        {value: 'country', compare:'cn'}],
    actions: {
        filterModel: function (searchArray, page, column, sortType) {
            this.set('searchArray', searchArray);
            return this.get('store').query('tcrUser', {
                page: page,
                offset: this.get('offset'),
                sidx: column,
                sord: sortType,
                filters: JSON.stringify(searchArray),
                promoCode: this.get('promoCode')
            });
        },

        agentSelected(agent){
            if (agent && agent.get('agentId') ) {
                this.set('promoCode', agent.get('agentId'));
            } else {
                this.set('promoCode', undefined);
            }
            this.store.query('tcr-user', {
                page: 1,
                offset: this.get('offset'),
                sidx: 'id',
                sord: 'asc',
                filters: JSON.stringify(this.get('searchArray')),
                promoCode: this.get('promoCode')
            }).then((model)=>{
                this.set('model', model);
                this.set('maxPages', this.get('model.meta.pages'));
                this.set('totalItems', this.get('model.meta.totalItems'));
            });

        }
    },

    search: task(function * (text, page, perPage) {
        yield timeout(200);
        return this.searchQuery(page, text, perPage);
    }),

    searchQuery(page, text, perPage){
        return this.get('store').query('agent', {page:page, rows:perPage, search: text, searchField: 'agent.email'}).then(results => results);
    }
});