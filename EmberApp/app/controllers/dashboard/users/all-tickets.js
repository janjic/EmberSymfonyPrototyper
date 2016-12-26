import Ember from 'ember';
const Translator = window.Translator;
const { service } = Ember.inject;

export default Ember.Controller.extend({
    store: service(),
    currentUser: service('current-user'),
    groupsModel: [],
    page: 1,
    offset: 10,
    colNames: ['ID', 'Title', 'Type', ' Status', 'Date', 'Author', 'Actions'],
    colModels: Ember.computed('groupsModel', function () {
        return [{value: 'id', compare:'cn'},
            {value: 'title', compare:'cn'},
            {value: 'type', compare:'eq', compareValues: [{name: Translator.trans('models.ticket.all'), value: -1}, {name: Translator.trans('models.ticket.types.bug.report'), value: 'BUG_REPORT'}, {name: Translator.trans('models.ticket.types.wrong.order'), value: 'WRONG_ORDER'}, {name: Translator.trans('models.ticket.types.order.inquiry'), value: 'ORDER_INQUIRY'}]},
            {value: 'status', compare:'eq', compareValues: [{name: Translator.trans('models.ticket.all'), value: -1}, {name: Translator.trans('models.ticket.status.new'), value: 'NEW'}, {name: Translator.trans('models.ticket.status.active'), value: 'ACTIVE'}, {name: Translator.trans('models.ticket.status.resolved'), value: 'RESOLVED'}]},
            {value: 'createdAt', compare:'cn', formatter: function (value) {
                return value.split('.')[0];
            }},
            {value: 'createdBy', compare:'cn', formatter: function (value) {
                return value.get('username');
            }},
        ];
    }),
    actions: {
        filterModel: function (searchArray, page, column, sortType) {
            return this.get('store').query('ticket', {
                page: page,
                offset: this.get('offset'),
                sidx: column,
                sord: sortType,
                filters: JSON.stringify(searchArray),
                additionalData: {ticketsType: 'forwardedTo', agentId: 'null'}
            });
        }
    }
});
