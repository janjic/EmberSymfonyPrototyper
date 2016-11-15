// app/adapter/application.js

import DS from 'ember-data';
import DataAdapterMixin from 'ember-simple-auth/mixins/data-adapter-mixin';

export default DS.JSONAPIAdapter.extend(DataAdapterMixin, {
    namespace: 'app_dev.php/api',
    authorizer: 'authorizer:application',

    urlForCreateRecord(){
        return 'https://192.168.11.3/app_dev.php/api/image-save';
    }
});