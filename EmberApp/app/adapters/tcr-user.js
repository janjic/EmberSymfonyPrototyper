import TCRCoreAdapter from './tcr-core-adapter';
const {Routing} = window;

export default TCRCoreAdapter.extend({
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
        return this.get('ajaxService').request(url, options).then(response => {
            return response;
        });
    },
    urlForFindRecord(id) {
            return Routing.generate('api_tcr_users', {id});
    },

    urlForUpdateRecord: function(id) {
        return Routing.generate('api_tcr_users', {id});
    }
});
