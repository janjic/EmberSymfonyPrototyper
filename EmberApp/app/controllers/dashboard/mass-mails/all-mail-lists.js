import Ember from 'ember';

export default Ember.Controller.extend({
    page: 1,
    offset: 10,
    colNames: ['ID', 'Name', 'From address', 'From name', 'Actions'],
    colModels: Ember.computed('groupsModel', function () {
        return [{value: 'id', compare:'cn', searchable: false, sortable: false},
            {value: 'name', compare:'cn', searchable: false, sortable: false},
            {value: 'fromAddress', compare:'cn', searchable: false, sortable: false},
            {value: 'fromName', compare:'cn', searchable: false, sortable: false},
        ];
    }),
    actions: {
        filterModel: function (searchArray, page, column, sortType) {
            return this.get('store').query('mail-list', {
                page: page,
                offset: this.get('offset'),
                sidx: column,
                sord: sortType,
                filters: JSON.stringify(searchArray),
            });
        }
    }
});
