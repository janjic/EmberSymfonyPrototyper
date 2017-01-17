import TCRCoreAdapter from './tcr-core-adapter';

export default TCRCoreAdapter.extend( {
    query(store, type, query){
        if (typeof query['filters'] === 'string') {
            query['filters'] = JSON.parse(query['filters']);
        }
        /**
         * Most efficient cloning method that works!
         */
        let clonedQuery = JSON.parse(JSON.stringify(query));

        clonedQuery['rows'] = clonedQuery['offset'];
        clonedQuery['_search'] = true;

        if(typeof clonedQuery['filters'] !== 'undefined' && clonedQuery['filters'].rules.length){
            clonedQuery['filters'].rules.forEach(function (item, index, array) {
                if(item.field === 'firstName'){
                    array[index].field = 'name';
                    array[index].data = item.data;
                } else if(item.field  === 'lastName'){
                    array[index].field = 'surname';
                    array[index].data = item.data;
                }
            });
        }

        clonedQuery['filters'] = JSON.stringify(clonedQuery['filters']);
        let url = this.get('host') + '/json/get-jqgrid-user-all';
        let options = {
            method: 'POST',
            data: clonedQuery,
        };
        console.log(options);
        return this.get('ajax').request(url, options).then(response => {


            return response;
        });
    },
    // findRecord(store, type, id){
    //     let url = this.get('host') + '/orders/order-preview-complete/'+id;
    //     let options = {
    //         method: 'GET',
    //     };
    //
    //     return this.get('ajax').request(url, options).then(response => {
    //         return response;
    //     });
    // }
});
