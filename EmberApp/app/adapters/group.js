import DS from 'ember-data';
import DataAdapterMixin from 'ember-simple-auth/mixins/data-adapter-mixin';

export default DS.RESTAdapter.extend(DataAdapterMixin, {
    namespace: 'api',
    authorizer: 'authorizer:application',

    urlForFindAll() {
        return 'https://192.168.11.3/app_dev.php/api/groups/all';
        // return Routing.generate('api_groups_all', {_locale: Translator.locale}, true);
    },

    urlForCreateRecord() {
        return 'https://192.168.11.3/app_dev.php/api/groups/add';
        // return Routing.generate('api_groups_all', {_locale: Translator.locale}, true);
    },

    deleteRecord: function(store, type, snapshot) {
        // console.log(snapshot.record.newParent.id);

        var url = 'https://192.168.11.3/app_dev.php/api/groups/delete/'+snapshot.id+'/'+snapshot.record.newParent.id;

        return this.ajax(url, "POST");
    }

});