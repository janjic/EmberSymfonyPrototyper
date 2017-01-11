import Ember from 'ember';
const {Datamap} = window;

export default Ember.Component.extend({
    session              :   Ember.inject.service('session'),
    dataArray            :   [],
    topCountries         :   [],
    bubbleMap            :   null,
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

        let id = this.get('model.id');
        let ctx = this;
        Ember.$.ajax({
            type: "GET",
            url: "/app_dev.php/api/agents-by-country",
            contentType: "application/pdf",
        }).then(function (response) {
            ctx.set('bubble_map', new Datamap({
                    element: document.getElementById("bubbles"),
                    geographyConfig: {
                        popupOnHover: false,
                        highlightOnHover: true,
                        highlightFillColor: '#c0392b'
                    },
                    fills: {
                        defaultFill: '#34495e',
                        '1': '#C0392B',
                        '2': '#C0742B',
                        '3': '#1D6876',
                        '4': '#21913A'
                    },
                    done: function(datamap) {
                        datamap.svg.call(d3.behavior.zoom().on("zoom", redraw));
                        function redraw() {
                            datamap.svg.selectAll("g").attr("transform", "translate(" + d3.event.translate + ")scale(" + d3.event.scale + ")");
                        }
                    },
                    setProjection: function(element) {
                        let projection = d3.geo.equirectangular()
                            .center([15, 35])
                            .rotate([4.4, 0])
                            .scale(350)
                            .translate([element.offsetWidth / 2, element.offsetHeight / 2]);
                        let path = d3.geo.path()
                            .projection(projection);

                        return {path: path, projection: projection};
                    }
                })
            );

            response.forEach(function (item) {
                let arrayItem = {};
                arrayItem['name'] = item['agentsNumb']+' new agents';
                arrayItem['radius']  = setFillKey(item['agentsNumb'])*6;
                arrayItem['centered']  = item['nationality'];
                arrayItem['countryCode']  = item['countryIsoCode'];
                arrayItem['country']  = item['nationality'];
                arrayItem['count'] = item['agentsNumb'];
                arrayItem['fillKey'] = setFillKey(item['agentsNumb']);
                ctx.get('dataArray').push(arrayItem);
            });

            function setFillKey(numb){
                if(numb < 10){
                    return '1';
                } else if( numb >= 10 && numb < 100) {
                    return '2';
                } else if(numb >= 100 && numb < 1000 ){
                    return '3';
                } else if(numb >= 1000){
                    return '4';
                }
            }

            ctx.get('bubble_map').bubbles(ctx.get('dataArray'),{
                popupTemplate: function(geo, data) {
                    return '<div class="hoverinfo input-box text-center"><h5><span class="flag flag-'+data.countryCode+'" alt="Country"></span>'+ data.country +'</h5>' + '<h6><i class="fa fa-users"></i> Agents: '+ data.count+'</h6>'
                }
            });

            ctx.set('topCountries', response.slice(0,3));
        });
    }, actions :{
        filterDataArray(category){

            let array = [];

            if(category == 1){
                array = this.get('dataArray').filter(function( obj ) {
                    return obj.count < 10;
                });
            } else if(category == 2){
                array = this.get('dataArray').filter(function( obj ) {
                    return (obj.count >= 10 && obj.count < 100);
                });
            } else if(category == 3){
                array = this.get('dataArray').filter(function( obj ) {
                    return (obj.count >= 100 && obj.count < 1000);
                });
            } else if(category == 4){
                array = this.get('dataArray').filter(function( obj ) {
                    return obj.count >= 1000;
                });
            } else if(category == -1){
                array = JSON.parse(JSON.stringify(this.get('dataArray')));
            }

            this.get('bubble_map').bubbles(array,{
                popupTemplate: function(geo, data) {
                    return '<div class="hoverinfo input-box text-center"><h5><span class="flag flag-'+data.countryCode+'" alt="Country"></span>'+ data.country +'</h5>' + '<h6><i class="fa fa-users"></i> Agents: '+ data.count+'</h6>'
                }
            });
        }
    }
});
