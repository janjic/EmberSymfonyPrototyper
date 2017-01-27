import Ember from 'ember';
const {Highcharts} = window;
const {service} = Ember.inject;
const {Routing} = window;
import { task } from 'ember-concurrency';

export default Ember.Component.extend({
    session     : Ember.inject.service('session'),
    currentUser : service('current-user'),
    currency    : 'EUR',
    chart       : null,
    bonusChart  : null,
    barChartData: null,

    setUpGraph: task(function * () {

        let accessToken = `Bearer ${this.get('session.data.authenticated.access_token')}`;

        Ember.$.ajaxSetup({
            beforeSend: (xhr) => {
                accessToken = `Bearer ${this.get('session.data.authenticated.access_token')}`;
                xhr.setRequestHeader('Authorization', accessToken);
            },
            headers: { 'Authorization': accessToken }
        });
        let response = yield Ember.$.ajax({
            type: "POST",
            url: Routing.generate('commission-by-agent'),
            data: {
                currency:this.get('currency'),
                agentId: this.get('currentUser.user.id')
            }
        });

        this.set('barChartData', response);

        let xAxis = {
            categories: ['Package Commission', 'Connect Commission', 'Setup Fee Commission', 'Stream Commission'],
        };
        let series = [];
        let pieData = [];
        let connectAvg = 0;
        let packagesAvg = 0;
        let setupFeeAvg = 0;
        let streamAvg = 0;
        response.forEach((item, index) => {
            series.push({
                type: 'column',
                name: item.agentName,
                data: [parseFloat(item.connectCommission), parseFloat(item.packagesCommission), parseFloat(item.setupFeeCommission), parseFloat(item.streamCommission)]
            });

            pieData.push({
                name: item.agentName,
                y: parseFloat(item.totalCommission)
            });

            connectAvg  = parseFloat(((connectAvg*index+parseFloat(item.connectCommission))/(index+1)).toFixed(2));
            packagesAvg = parseFloat(((packagesAvg*index+parseFloat(item.packagesCommission))/(index+1)).toFixed(2));
            setupFeeAvg = parseFloat(((setupFeeAvg*index+parseFloat(item.setupFeeCommission))/(index+1)).toFixed(2));
            streamAvg   = parseFloat(((streamAvg*index+parseFloat(item.streamCommission))/(index+1)).toFixed(2));
        });

        series.push({
                type: 'spline',
                name: 'Average',
                data: [connectAvg, packagesAvg, setupFeeAvg, streamAvg],
                marker: {
                    lineWidth: 2,
                    lineColor: Highcharts.getOptions().colors[3],
                    fillColor: 'white'
                }
            }

            // {
            //     type: 'pie',
            //     name: 'Total Commission',
            //     data: pieData,
            //     center: [0, 0],
            //     size: 100,
            //     showInLegend: false,
            //     dataLabels: {
            //         enabled: false
            //     }
            // }
        );

            this.set('chart', Highcharts.chart('highchart', {
                title: {
                    text: 'Top 5 agents earnings by type'
                },
                credits: {
                    enabled: false
                },
                xAxis: xAxis,
                labels: {
                    items: [{
                        html: 'Total Agent Earnings',
                        style: {
                            left: '50px',
                            top: '18px',
                            color: (Highcharts.theme && Highcharts.theme.textColor) || 'black'
                        }
                    }]
                },
                tooltip: {
                    valueSuffix: ' ' + this.get('currency')
                },
                series: series
            }));


    }).restartable(),

    didInsertElement() {
        this._super(...arguments);
        this.get('setUpGraph').perform();
    },

    actions: {
        /**
         * Handle currency changed on bar data
         * @param currency
         */
        currencyChanged(currency)
        {
            if(currency !== this.get('currency')){
                this.set('currency', currency);
                this.get('setUpGraph').perform();
            }
        },
    }
});
