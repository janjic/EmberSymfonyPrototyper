import Ember from 'ember';
import DS from 'ember-data';

export default DS.JSONAPIAdapter.extend( {
    ajax: Ember.inject.service(),
    host: 'https://tcr-media.fsd.rs:105/app_dev.php/en',
    namespace: '',
    query(store, type, query){
        query['rows'] = query['offset'];
        query['_search'] = true;
        if(query['filters'].rules.length){
            query['filters'].rules.forEach(function (item, index, array) {
                if(item.field === 'name'){
                    array[index].field = 'user.name';
                }
                if(item.field  === 'surname'){
                    array[index].field = 'user.surname';
                }
            });
        }

        query['filters'] = JSON.stringify(query['filters']);
        let url = this.get('host') + '/orders/orders-list-complete-purchases-json';
        let options = {
            method: 'POST',
            data: query,
        };
        return this.get('ajax').request(url, options).then(response => {
            return response;
        });
    },
    findRecord(store, type, id, snapshot){
        let url = this.get('host') + '/orders/order-preview-complete/'+id;
        let options = {
            method: 'GET',
        };

        return this.get('ajax').request(url, options).then(response => {
            return response;
        });
    }
});

