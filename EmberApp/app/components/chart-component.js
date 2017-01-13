import Ember from 'ember';
const {Highcharts} = window;
const {service} = Ember.inject;

export default Ember.Component.extend({
    session     : Ember.inject.service('session'),
    currentUser : service('current-user'),
    currency    : 'EUR',
    chart       : null,
    bonusChart  : null,
    barChartData: null,
    didInsertElement() {
        /** set access token to ajax requests sent by orgchart library */
        let accessToken = `Bearer ${this.get('session.data.authenticated.access_token')}`;

        Ember.$.ajaxSetup({
            beforeSend: (xhr) => {
                accessToken = `Bearer ${this.get('session.data.authenticated.access_token')}`;
                xhr.setRequestHeader('Authorization', accessToken);
            },
            headers: { 'Authorization': accessToken }
        });

        /**
         * Load bar chart data
         */
        this.loadGraphData(this);

        // this.loadBonusesData();


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
                this.loadGraphData(this);
            }
        },
    },
    loadGraphData(ctx){
        Ember.$.ajax({
            type: "POST",
            url: "/app_dev.php/api/payment/commission-by-agent/",
            data: {
                currency:this.get('currency'),
                agentId: this.get('currentUser.user.id')
            }
        }).then(function (response) {
            ctx.set('barChartData', response);

            let xAxis = {
                categories: ['Package Commission', 'Connect Commission', 'Setup Fee Commission', 'Stream Commission'],
            };
            let series = [];
            let pieData = [];
            let connectAvg = 0;
            let packagesAvg = 0;
            let setupFeeAvg = 0;
            let streamAvg = 0;
            response.forEach(function (item, index) {
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
            ctx.set('chart', Highcharts.chart('highchart', {
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
                    valueSuffix: ' '+ctx.get('currency')
                },
                series: series
            }));
        });
    },

    loadBonusesData()
    {
        Ember.$.ajax({
            type: "GET",
            url: "/app_dev.php/api/payment/bonuses-by-agent/"+this.get('currency')
        }).then(function (response) {
            console.log(response);
        });
        this.set('bonusChart', Highcharts.chart('container', {
            title: {
                text: 'Agent bonuses per month',
                x: -20 //center
            },
            credits: {
                enabled: false
            },

            xAxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                    'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
            },
            yAxis: {
                title: {
                    text: 'Number'
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {
                valueSuffix: '°C'
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle',
                borderWidth: 0
            },
            series: [{
                name: 'Ambasadors',
                data: [7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]
            }, {
                name: 'Referees',
                data: [-0.2, 0.8, 5.7, 11.3, 17.0, 22.0, 24.8, 24.1, 20.1, 14.1, 8.6, 2.5]
            }, {
                name: 'Masters',
                data: [-0.9, 0.6, 3.5, 8.4, 13.5, 17.0, 18.6, 17.9, 14.3, 9.0, 3.9, 1.0]
            }, {
                name: 'Admins',
                data: [3.9, 4.2, 5.7, 8.5, 11.9, 15.2, 17.0, 16.6, 14.2, 10.3, 6.6, 4.8]
            }]
        }));
    }

});
