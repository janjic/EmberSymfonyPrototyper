// app/adapter/application.js

import DS from 'ember-data';
import DataAdapterMixin from 'ember-simple-auth/mixins/data-adapter-mixin';

export default DS.JSONAPI.extend(DataAdapterMixin, {
    namespace: 'api',
    authorizer: 'authorizer:application'
});