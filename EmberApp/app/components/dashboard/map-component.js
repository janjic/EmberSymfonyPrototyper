import Ember from 'ember';

const {Datamap, d3, Routing} = window;
import { task, timeout } from 'ember-concurrency';

export default Ember.Component.extend({
    session              :   Ember.inject.service('session'),
    dataArray            :   [],
    topCountries         :   [],
    bubbleMap            :   null,

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
            type: "GET",
            url: Routing.generate('agents-by-country'),
            contentType: "application/pdf",
        });
        this.set('bubble_map', new Datamap({
                element: document.getElementById("bubbles"),
                geographyConfig: {
                    popupOnHover: false,
                    highlightOnHover: true,
                    highlightFillColor: '#c0392b'
                },
                fills: {
                    defaultFill: '#34495e',
                    '1': '#C0392B',
                    '2': '#f39c12',
                    '3': '#1D6876',
                    '4': '#21913A'
                },
                done: function(datamap) {
                    datamap.svg.call(d3.behavior.zoom().on("zoom", ()=> {
                        datamap.svg.selectAll("g").attr("transform", "translate(" + d3.event.translate + ")scale(" + d3.event.scale + ")");

                    }));

                },
                setProjection: function(element) {
                    let projection = d3.geo.equirectangular()
                        .center([15, 50])
                        .rotate([4.4, 0])
                        .scale(740)
                        .translate([element.offsetWidth / 2, element.offsetHeight / 2]);
                    let path = d3.geo.path()
                        .projection(projection);

                    return {path: path, projection: projection};
                }
            })
        );

        response.forEach( (item)=> {
            let arrayItem = {};
            arrayItem['name'] = item['agentsNumb']+' new agents';
            arrayItem['radius']  = setFillKey(item['agentsNumb'])*6;
            arrayItem['centered']  = item['countryIsoCode'];
            arrayItem['countryCode']  = item['countryFlagCode'];
            arrayItem['country']  = item['countryIsoCode'];
            arrayItem['countryName']  = item['nationality'];
            arrayItem['count'] = parseInt(item['agentsNumb']);
            arrayItem['fillKey'] = setFillKey(item['agentsNumb']);
            this.get('dataArray').push(arrayItem);
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

        this.get('bubble_map').bubbles(this.get('dataArray'),{
            popupTemplate: function(geo, data) {
                return '<div class="hoverinfo input-box text-center"><h5><span class="flag flag-'+data.countryCode+'" alt="Country"></span>'+ data.countryName +'</h5>' + '<h6><i class="fa fa-users"></i> Agents: '+ data.count+'</h6>';
            }
        });

        this.set('topCountries', response.slice(0,3));
    }).restartable(),

    didInsertElement() {
        this._super(...arguments);
        this.get('setUpGraph').perform();
    },

    actions :{
        filterDataArray(category){

            let array = [];

            if(category === 1){
                array = this.get('dataArray').filter(function( obj ) {
                    return obj.count < 10;
                });
            } else if(category === 2){
                array = this.get('dataArray').filter(function( obj ) {
                    return (obj.count >= 10 && obj.count < 100);
                });
            } else if(category === 3){
                array = this.get('dataArray').filter(function( obj ) {
                    return (obj.count >= 100 && obj.count < 1000);
                });
            } else if(category === 4){
                array = this.get('dataArray').filter(function( obj ) {
                    return obj.count >= 1000;
                });
            } else if(category === -1){
                array = JSON.parse(JSON.stringify(this.get('dataArray')));
            }

            this.get('bubble_map').bubbles(array,{
                popupTemplate: function(geo, data) {
                    return '<div class="hoverinfo input-box text-center"><h5><span class="flag flag-'+data.countryCode+'" alt="Country"></span>'+ data.countryName +'</h5>' + '<h6><i class="fa fa-users"></i> Agents: '+ data.count+'</h6>';
                }
            });
        }
    }
});
