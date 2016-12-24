import Ember from 'ember';

export default Ember.Controller.extend({
    page: 1,
    offset: 10,
    colNames: ['ID', 'Subject', 'Reply to', ' From name', 'Actions'],
    colModels: Ember.computed('groupsModel', function () {
        return [{value: 'id', compare:'cn', searchable: false, sortable: false},
            {value: 'subject_line', compare:'cn', searchable: false, sortable: false},
            {value: 'reply_to', compare:'cn', searchable: false, sortable: false},
            {value: 'from_name', compare:'cn', searchable: false, sortable: false},
        ];
    }),
    actions: {
        filterModel: function (searchArray, page, column, sortType) {
            return this.get('store').query('mail-campaign', {
                page: page,
                offset: this.get('offset'),
                sidx: column,
                sord: sortType,
                filters: JSON.stringify(searchArray),
            });
        }
    }
});
