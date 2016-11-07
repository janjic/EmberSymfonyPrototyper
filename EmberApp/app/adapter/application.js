// app/adapter/user.js

import DS from 'ember-data';
import DataAdapterMixin from 'ember-simple-auth/mixins/data-adapter-mixin';

export default DS.RESTAdapter.extend(DataAdapterMixin, {
    namespace: 'app_dev.php',
    authorizer: 'authorizer:application',

});