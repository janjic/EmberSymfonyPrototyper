import Ember from 'ember';
import moment from 'moment';
import LoadingStateMixin from '../../mixins/loading-state';
import { task, timeout } from 'ember-concurrency';

export default Ember.Component.extend(LoadingStateMixin, {
    page: 1,
    isModalOpen:false,
    eventBus: Ember.inject.service('event-bus'),

    paymentTypes: ['Commission', 'Bonus'],

    countryFilter: null,
    typeFilter: null,
    startDateFilter: null,
    endDateFilter: null,
    agentFilter: null,

    actions: {
        applyFilters () {
            let searchArray = {
                groupOp: 'AND',
                rules: []
            };

            if (this.get('countryFilter')) {
                searchArray.rules.addObject({
                    field: 'country',
                    op: 'eq',
                    data: this.get('countryFilter')
                });
            }

            if (this.get('typeFilter')) {
                searchArray.rules.addObject({
                    field: 'type',
                    op: 'eq',
                    data: this.get('typeFilter')
                });
            }

            if (this.get('startDateFilter')) {
                searchArray.rules.addObject({
                    field: 'startDate',
                    op: 'eq',
                    data: this.get('startDateFilter')
                });
            }

            if (this.get('endDateFilter')) {
                searchArray.rules.addObject({
                    field: 'endDate',
                    op: 'eq',
                    data: this.get('endDateFilter')
                });
            }

            if (this.get('agentFilter')) {
                searchArray.rules.addObject({
                    field: 'agent',
                    op: 'eq',
                    data: this.get('agentFilter.id')
                });
            }

            this.showLoader();
            this.get('filterModel')(searchArray, 1).then((results)=>{
                this.set('model', results);
                this.set('isModalOpen', false);
                this.disableLoader();
            });
        },

        openModal() {
            this.set('isModalOpen', true);
        },

        closeModal() {
            this.set('isModalOpen', false);
        },

        changeCountry(val) {
            this.set('countryFilter', val);
        },

        typeChange(val) {
            this.set('typeFilter', val);
        },

        applyDateChange(startDate, endDate) {
            this.setProperties({
                startDate, endDate
            });
            this.set('startDateFilter', startDate);
            this.set('endDateFilter', endDate);
        },

        cancelDateChange() {
            this.set('startDate', null);
            this.set('endDate', null);
            this.set('startDateFilter', null);
            this.set('endDateFilter', null);
        },

        agentSelected(agent) {
            this.set('agentFilter', agent);
        }
    },

    /** trigger search on event */
    _filterAction(){
        this.send('applyFilters');
    },

    _initialize: Ember.on('init', function(){
        this.get('eventBus').subscribe('triggerFilterAction', this, '_filterAction');
    }),

    _destroy: Ember.on('willDestroyElement', function(){
        this.get('eventBus').unsubscribe('triggerFilterAction');
    }),



    search: task(function * (text, page, perPage) {
        yield timeout(200);
        return this.get('searchAgentsAction')(page, perPage, text);
    }),

    /** datetime picker */
    daysOfWeek: [
        "Su",
        "Mo",
        "Tu",
        "We",
        "Th",
        "Fr",
        "Sa"
    ],
    monthNames: [
        "Enero",
        "Febrero",
        "Marzo",
        "Abril",
        "Mayo",
        "Junio",
        "Julio",
        "Agusto",
        "Septiembre",
        "Octubre",
        "Noviembre",
        "Diciembre"
    ],
    today : Ember.computed(function () {
        let date = new Date();
        return `${date.getFullYear()}/${date.getMonth() < 10 ? '0'+(date.getMonth()+1) :date.getMonth()+1} /${date.getDate() <10 ?'0'+(date.getDate()) :date.getDate()}`.replace(/\//g,'');
    }),
    ranges: {
        'Today': [moment(), moment()],
        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
        'This Month': [moment().startOf('month'), moment().endOf('month')],
        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    },
});
