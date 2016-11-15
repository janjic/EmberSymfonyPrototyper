import Ember from 'ember';

export default Ember.Controller.extend({
    page: 1,
    offset: 10,
    colNames: ['ID', 'First Name', 'Last Name', ' Username', 'Confirmed', 'Country', 'Actions'],
    colModels: [{value: 'id', compare:'eq', compareValues: [{name: 'First', value:'1'},{name: 'Second', value:'2'},{name: 'Third', value:'3'}]}, {value: 'firstName', compare:'cn'}, {value: 'lastName', compare:'eq', compareValues: [{name: 'First', value:'1'},{name: 'Second', value:'2'},{name: 'Third', value:'3'}]}, {value: 'username', compare:'cn'}, {value: 'enabled', compare:'cn'}, {value: 'address.streetNumber', compare:'cn'}],
    actions: {
        filterModel: function (searchArray, page, column, sortType) {
            return this.get('store').query('user', {
                page: page,
                offset: this.get('offset'),
                sidx: column,
                sord: sortType,
                filters: JSON.stringify(searchArray)
            });
        }
    }
});