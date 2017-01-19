import Ember from 'ember';
import PaymentInfoListingMixin from './../../../../mixins/payment-info-listing';
import LoadingStateMixin from './../../../../mixins/loading-state';
const {Routing, Highcharts, Translator} = window;

export default Ember.Controller.extend(PaymentInfoListingMixin, LoadingStateMixin, {
    session: Ember.inject.service('session'),
    eventBus: Ember.inject.service('event-bus'),

    selectedCurrency: 'EUR',
    noResultsFound: false,

    totalCommission: 0,
    unprocessedCommissions: 0,
    totalBonus: 0,
    unprocessedBonus: 0,


    init: function () {
        this._super();

        /** set access token to ajax requests sent by orgchart library */
        let accessToken = `Bearer ${this.get('session.data.authenticated.access_token')}`;

        Ember.$.ajaxSetup({
            beforeSend: (xhr) => {
                accessToken = `Bearer ${this.get('session.data.authenticated.access_token')}`;
                xhr.setRequestHeader('Authorization', accessToken);
            },
            headers: { 'Authorization': accessToken }
        });

        this.loadGraphData(this);
    },

    actions: {
        filterModel (searchArray, page) {
            return this.get('store').query('payment-info', {
                page: page,
                offset: this.get('offset'),
                sidx: 'id',
                sord: 'desc',
                filters: JSON.stringify(searchArray)
            });
        },

        applyDateChange(startDate, endDate) {
            this.set('startDate', startDate);
            this.set('endDate', endDate);
            this.loadGraphData(this);
            Ember.run.scheduleOnce('afterRender', this, function() {
                this.get('eventBus').publish('triggerFilterAction');
            });
        },

        cancelDateChange() {
            this.set('startDate', null);
            this.set('endDate', null);
            this.loadGraphData(this);
            Ember.run.scheduleOnce('afterRender', this, function() {
                this.get('eventBus').publish('triggerFilterAction');
            });
        },

        currencyChanged(val) {
            this.set('selectedCurrency', val);
            this.loadGraphData(this);
        }
    },

    loadGraphData(ctx){
        ctx.showLoader();
        Ember.$.ajax({
            type: "POST",
            url: '/app_dev.php'+Routing.generate('api_earnings_by_agent'),
            data: {
                dateFrom: this.get('startDate'),
                dateTo:   this.get('endDate'),
                currency: this.get('selectedCurrency'),
            }
        }).then(function (response) {

            ctx.disableLoader();

            ctx.set('noResultsFound', isNaN(parseFloat(response.totalCommission)) && isNaN(parseFloat(response.totalBonus)));
            if (ctx.get('noResultsFound')) {
                return;
            }

            var customSeries = [];

            customSeries.push({
                name: Translator.trans('commission.packages'),
                y: parseFloat(response.packagesCommission)
            });
            
            customSeries.push({
                name: Translator.trans('commission.connect'),
                y: parseFloat(response.connectCommission)
            });
            
            customSeries.push({
                name: Translator.trans('commission.setupFee'),
                y: parseFloat(response.setupFeeCommission)
            });
            
            customSeries.push({
                name: Translator.trans('commission.stream'),
                y: parseFloat(response.streamCommission)
            });
            
            customSeries.push({
                name: Translator.trans('commission.bonus'),
                y: parseFloat(response.totalBonus)
            });

            ctx.set('totalCommission', response.totalCommission);
            ctx.set('totalBonus', response.totalBonus);
            
            ctx.set('unprocessedBonus', response.unprocessedBonus);
            ctx.set('unprocessedCommissions', response.unprocessedCommissions);

            ctx.set('chart', Highcharts.chart('highchart', {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie'
                },
                credits: {
                    enabled: false
                },
                title: {
                    text: 'Processed earnings by type'
                },
                tooltip: {
                    valueSuffix: ' '+ctx.get('selectedCurrency')
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: false
                        },
                        showInLegend: true
                    }
                },
                series: [{
                    name: 'Earning',
                    colorByPoint: true,
                    data: customSeries
                }]
            }));
        });
    },
});