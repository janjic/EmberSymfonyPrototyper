// app/adapter/user.js

import DS from 'ember-data';
import DataAdapterMixin from 'ember-simple-auth/mixins/data-adapter-mixin';

export default DS.RESTAdapter.extend(DataAdapterMixin, {
    namespace: 'api',
    authorizer: 'authorizer:application',

    urlForFindAll() {
        return Routing.generate('json-menu-items', {_locale: Translator.locale}, true);
    },

});