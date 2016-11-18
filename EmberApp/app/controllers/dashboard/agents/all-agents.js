import Ember from 'ember';

export default Ember.Controller.extend({
    page: 1,
    offset: 10,
    colNames: ['ID', 'First Name', 'Last Name', ' Username', 'Agent Type', 'Country', 'Status', 'Actions'],
    colModels: [{value: 'id', compare:'cn'},
                {value: 'firstName', compare:'cn'},
                {value: 'lastName', compare:'cn'},
                {value: 'username', compare:'cn'},
                {value: 'group.name', compare:'cn'},
                {value: 'address.country', compare:'cn'},
                {value: 'enabled', compare:'cn'}
    ],
    actions: {
        filterModel: function (searchArray, page, column, sortType) {
            return this.get('store').query('agent', {
                page: page,
                offset: this.get('offset'),
                sidx: column,
                sord: sortType,
                filters: JSON.stringify(searchArray)
            });
        }
    }
});
