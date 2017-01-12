import Ember from 'ember';
const {Highcharts} = window;
export default Ember.Component.extend({
    session   :   Ember.inject.service('session'),
    currency  : 'EUR',
    chart     : null,
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

        this.loadGraphData(this);
    },
    actions: {
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
            type: "GET",
            url: "/app_dev.php/api/payment/commission-by-agent/"+this.get('currency')
        }).then(function (response) {

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
                , {
                    type: 'pie',
                    name: 'Total Commission',
                    data: pieData,
                    center: [0, 0],
                    size: 100,
                    showInLegend: false,
                    dataLabels: {
                        enabled: false
                    }
                });


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
                valueSuffix: 'CHF',
                series: series
            }));
        });
    }

});
