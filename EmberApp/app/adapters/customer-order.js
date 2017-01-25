import TCRCoreAdapter from './tcr-core-adapter';

export default TCRCoreAdapter.extend( {
    query(store, type, query){
        /**
         * Most efficient cloning method that works!
         */
        let clonedQuery = JSON.parse(JSON.stringify(query));

        clonedQuery['rows'] = clonedQuery['offset'];
        clonedQuery['_search'] = true;

        if(typeof clonedQuery['filters'] !== 'undefined' && typeof clonedQuery['filters'].rules !== 'undefined' && clonedQuery['filters'].rules.length){
            clonedQuery['filters'].rules.forEach(function (item, index, array) {
                if(item.field === 'name'){
                    array[index].field = 'user.name';
                    array[index].data = item.data;
                }
                if(item.field  === 'surname'){
                    array[index].field = 'user.surname';
                    array[index].data = item.data;
                }
            });
        }

        if(clonedQuery['sidx'] === 'name'){
            clonedQuery['sidx'] = 'user.name';
        }
        if(clonedQuery['sidx']  === 'surname'){
            clonedQuery['sidx'] = 'user.surname';
        }
        clonedQuery['offset'] = undefined;

        clonedQuery['filters'] = JSON.stringify(clonedQuery['filters']);
        let url = this.get('host') + '/orders/orders-list-complete-purchases-json';
        let options = {
            method: 'POST',
            data: clonedQuery,
        };
        return this.get('ajaxService').request(url, options).then(response => {


            return response;
        });
    },
    findRecord(store, type, id){
        let url = this.get('host') + '/orders/order-preview-complete/'+id;
        let options = {
            method: 'GET',
        };

        return this.get('ajaxService').request(url, options).then(response => {
            return response;
        });
    }
});

