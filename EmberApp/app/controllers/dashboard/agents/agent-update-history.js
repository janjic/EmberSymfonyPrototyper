import Ember from 'ember';
const Translator = window.Translator;

export default Ember.Controller.extend({
    updateTypes: [{name: 'Upgrade', key: 'UPGRADE'}, {name: 'Downgrade', key: 'DOWNGRADE'}, {name: 'Suspension', key: 'SUSPENSION'}],
    currentUpdateType: {name: 'Upgrade', key: 'UPGRADE'},

    store: Ember.inject.service(),
    eventBus: Ember.inject.service('event-bus'),

    page: 1,
    offset: 10,
    colNames: [
        'admin-agent.history.agent.id',
        'admin-agent.history.agent.name',
        'admin-agent.history.changed.by',
        'admin-agent.history.changed.from',
        'admin-agent.history.changed.to',
        'admin-agent.history.is.suspended',
        'admin-agent.history.date',
        'admin-agent.history.actions',
    ],

    colModels: [
        {value: 'agent.id', compare:'cn'},
        {value: 'agent.fullName', compare:'cn'},
        {value: 'changedByAgent.fullName', compare:'cn'},
        {value: 'changedFrom.name', compare:'cn'},
        {value: 'changedTo.name', compare:'cn'},
        {value: 'changedToSuspended', compare:'eq', compareValues: [
            {name: Translator.trans('admin-agent.history.all'), value: -1},
            {name: Translator.trans('admin-agent.history.suspended'), value: 1},
            {name: Translator.trans('admin-agent.history.not.suspended'), value: 0}
        ], formatter: function (value) {
            if (value === false) {
                return Translator.trans('admin-agent.history.not.suspended');
            }
            return Translator.trans('admin-agent.history.suspended');
        }},
        {value: 'date', compare:'cn', formatter: function (value) {
            return value.split('.')[0];
        }}
    ],

    actions: {
        filterModel: function (searchArray, page, column, sortType) {
            return this.get('store').query('agent-history', {
                page: page,
                offset: this.get('offset'),
                sidx: column,
                sord: sortType,
                filters: JSON.stringify(searchArray),
                type: this.get('currentUpdateType.key')
            });
        },

        updateTypeChanged(type) {
            this.set('currentUpdateType', type);
            this.get('eventBus').publish('resetTableEvent');
        }
    }
});
