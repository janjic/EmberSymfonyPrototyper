import Ember from 'ember';
import LoadingStateMixin from '../../mixins/loading-state';
import DateRangesMixin from '../../mixins/date-picker-fields';
import { task, timeout } from 'ember-concurrency';

const {Routing, ApiCode, download} = window;

export default Ember.Component.extend(LoadingStateMixin, DateRangesMixin, {
    page: 1,
    isModalOpen:false,
    eventBus: Ember.inject.service('event-bus'),
    authorizedAjax: Ember.inject.service('authorized-ajax'),

    paymentTypes: ['Commission', 'Bonus'],

    countryFilter: null,
    typeFilter: null,
    startDateFilter: null,
    endDateFilter: null,
    agentFilter: null,

    init(){
        this._super(...arguments);
        this.set('agentFilter', null);
        this.set('endDateFilter', null);
        this.set('startDateFilter', null);
        this.set('typeFilter', null);
        this.set('countryFilter', null);

        this.set('initialLength', this.get('model.length'));
    },

    actions: {
        _applyFilters(){
            this.set('page', 1);
            this.send('applyFilters');
        },

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
            this.get('filterModel')(searchArray, this.get('page')).then((results)=>{
                this.set('maxPages', results.meta.pages);
                this.set('totalItems', results.meta.totalItems);
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
        },

        payAll() {
            this.changeStateForAll(true);
        },

        rejectAll() {
            this.changeStateForAll(false);
        },

        exportResults(){
            this.set('isCSVLoading', true);

            let accessToken = `Bearer ${this.get('session.data.authenticated.access_token')}`;

            Ember.$.ajaxSetup({
                beforeSend: (xhr) => {
                    accessToken = `Bearer ${this.get('session.data.authenticated.access_token')}`;
                    xhr.setRequestHeader('Authorization', accessToken);
                },
                headers: { 'Authorization': accessToken }
            });

            // let filterArray = this.get('');
            let ctx = this;
            let today = new Date();
            let date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();

            Ember.$.ajax({
                type: "GET",
                url: Routing.generate('payments_csv'),
                contentType: "text/csv",
            }).then(function (response) {
                download(response, "report-"+today+".csv", "text/csv");
                ctx.set('isCSVLoading', false);
            });


            // this.get('authorizedAjax').sendAuthorizedRequest(null, 'GET', Routing.generate('payments_csv'),
            //     function (response) {
            //         download(response);
            //         this.set('isCSVLoading', false);
            //     }.bind(this), this);
        }
    },

    changeStateForAll(newState) {
        let options = {
            newState: newState
        };

        this.get('authorizedAjax').sendAuthorizedRequest(options, 'POST', Routing.generate('api_execute_all_payments'), function (response) {
            switch (parseInt(response.meta.status)) {
                case ApiCode.PAYMENT_EXECUTE_ALL_ERROR:
                    this.toast.error('ERROR!');
                    break;
                case ApiCode.PAYMENT_EXECUTE_ALL_SUCCESS:
                    if (newState) {
                        this.toast.success('Payments successfull');
                        this.get('goToRoute')('dashboard.payments.reports');
                    } else {
                        this.get('goToRoute')('dashboard.payments.rejected-payments');
                    }
                    break;
                default:
                    return;
            }
        }.bind(this), this);
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
});
