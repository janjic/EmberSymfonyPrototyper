import TCRCoreAdapter from './tcr-core-adapter';

export default TCRCoreAdapter.extend( {
    queryRecord(store, type, query){
        /**
         * Most efficient cloning method that works!
         */
        let clonedQuery = JSON.parse(JSON.stringify(query));

        let widgetType = clonedQuery['type'];

        let url = this.get('host') + '/json/get-new-'+widgetType+'-info';
        let options = {
            method: 'POST',
            data: clonedQuery,
        };
        return this.get('ajax').request(url, options);
    }
});

