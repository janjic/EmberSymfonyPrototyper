// app/adapter/application.js

import DS from 'ember-data';
import DataAdapterMixin from 'ember-simple-auth/mixins/data-adapter-mixin';
const Routing = window.Routing;

export default DS.JSONAPIAdapter.extend(DataAdapterMixin, {
    namespace: 'app_dev.php/api',
    authorizer: 'authorizer:application',

    urlForCreateRecord: function () {
        return Routing.generate('api_agent_save');
    }
});