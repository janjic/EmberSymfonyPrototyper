import DS from 'ember-data';
import DataAdapterMixin from 'ember-simple-auth/mixins/data-adapter-mixin';

export default DS.RESTAdapter.extend(DataAdapterMixin, {
    namespace: 'api',
    authorizer: 'authorizer:application',

    urlForFindAll() {
        return 'https://192.168.11.3/app_dev.php/api/roles/all';
        // return Routing.generate('api_groups_all', {_locale: Translator.locale}, true);
    },

    urlForCreateRecord() {
        return 'https://192.168.11.3/app_dev.php/api/roles/add';
        // return Routing.generate('api_groups_all', {_locale: Translator.locale}, true);
    },

    deleteRecord: function(store, type, snapshot) {
        var url = 'https://192.168.11.3/app_dev.php/api/roles/delete/'+snapshot.id;

        return this.ajax(url, "POST");
    }

});