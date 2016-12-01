import Ember from 'ember';
const Translator = window.Translator;

export default Ember.Controller.extend({
    store: Ember.inject.service(),
    groupsModel: [],
    page: 1,
    offset: 10,
    colNames: ['ID', 'First Name', 'Last Name', ' Username', 'Agent Type', 'Country', 'Status', 'Actions'],
    colModels: Ember.computed('groupsModel', function () {
        return [{value: 'id', compare:'cn'},
            {value: 'firstName', compare:'cn'},
            {value: 'lastName', compare:'cn'},
            {value: 'username', compare:'cn'},
            {value: 'group.name', compare:'eq', compareValues: this.groupsModel},
            {value: 'address.country', compare:'cn'},
            {value: 'enabled', compare:'eq', compareValues: [{name: Translator.trans('All'), value: -1}, {name: Translator.trans('Enabled'), value: 1}, {name: Translator.trans('Not Enabled'), value: 0}], formatter: function (value) {
                return value ? Translator.trans('Enabled'): Translator.trans('Not enabled');
            }}
        ]
    }),
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
