import Ember from 'ember';
const Translator = window.Translator;

export default Ember.Controller.extend({
    store: Ember.inject.service(),
    groupsModel: [],
    groups: [],
    page: 1,
    offset: 10,
    colNames: ['ID', 'First Name', 'Last Name', ' Username', 'Agent Type', 'Country', 'Status', 'Actions'],
    colModels: [{value: 'id', compare:'cn'},
        {value: 'firstName', compare:'cn'},
        {value: 'lastName', compare:'cn'},
        {value: 'username', compare:'cn'},
        {value: 'group.name', compare:'eq', compareValues: this.groupsModel},
        {value: 'address.country', compare:'cn'},
        {value: 'enabled', compare:'eq', compareValues: [{name: Translator.trans('All'), value: -1}, {name: Translator.trans('Enabled'), value: 1}, {name: Translator.trans('Not Enabled'), value: 0}]}
    ],
    init: function () {
        this.store.findAll('group').then((items)=> {
            this.set('groups', items);
        });
        console.log(this.get('groups'));
        this.get('groups').forEach(function (item) {

        });
    },
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
