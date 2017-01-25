import Ember from 'ember';
import { task, timeout } from 'ember-concurrency';

export default Ember.Controller.extend({
    page: 1,
    offset: 10,
    searchArray: {
        groupOp:"AND",
        rules: []
    },
    agentRule: [],

    agentId : undefined,
    colNames: ['ID', 'Name', 'Surname', 'Order total', 'Date', 'Actions'],

    colModels: Ember.computed('groupsModel', function () {
        return [
            {value: 'id', compare:'cn'},
            {value: 'name', compare:'cn'},
            {value: 'surname', compare:'cn'},
            {value: 'total', compare:'cn'},
            {value: 'created_at', compare:'cn', formatter: function (value) {
                return value.split('T')[0];
            }},
        ];
    }),
    actions: {
        filterModel: function (searchArray, page, column, sortType) {

            this.set('searchArray', searchArray);

            let clonedArray = JSON.parse(JSON.stringify(searchArray));

            if ( this.get('agentId') ){
                clonedArray.rules.push({
                    field: 'user.agent.agent_id',
                    op: 'cn',
                    data: this.get('agentId')
                });
            }
            return this.get('store').query('customer-order', {
                page: page,
                offset: this.get('offset'),
                sidx: column,
                sord: sortType,
                filters: clonedArray,
            });
        },
        agentSelected(agent){
            if (agent && agent.get('agentId') ) {
                this.set('agentId', agent.get('agentId'));
            } else {
                this.set('agentId', undefined);
            }

            let clonedArray = JSON.parse(JSON.stringify(this.get('searchArray')));

            if ( this.get('agentId') ){
                clonedArray.rules.push({
                    field: 'user.agent.agent_id',
                    op: 'cn',
                    data: this.get('agentId')
                });
            }

            this.store.query('customer-order', {
                page: 1,
                offset: this.get('offset'),
                sidx: 'id',
                sord: 'asc',
                filters: clonedArray,
            }).then((model)=>{
                this.set('model', model);
                this.set('page', 1);
                this.set('maxPages', this.get('model.meta.pages'));
                this.set('totalItems', this.get('model.meta.totalItems'));
            });
        },
    },

    search: task(function * (text, page, perPage) {
        yield timeout(200);
        return this.searchQuery(page, text, perPage);
    }),

    searchQuery(page, text, perPage){
        return this.get('store').query('agent', {page:page, rows:perPage, search: text, searchField: 'agent.email'}).then(results => results);
    }
});
