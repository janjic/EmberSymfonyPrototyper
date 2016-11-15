import DS from 'ember-data';
import DataAdapterMixin from 'ember-simple-auth/mixins/data-adapter-mixin';

export default DS.RESTAdapter.extend(DataAdapterMixin, {
    namespace: 'app_dev.php/api',
    authorizer: 'authorizer:application',

    deleteRecord: function(store, type, snapshot) {
        var url = this.buildURL(type.modelName, snapshot.id, snapshot, 'deleteRecord');
        var data = {id: snapshot.id, newParent: snapshot.record.newParent.id};

        return this.ajax(url, "DELETE", {dataType: 'json', data: data});
    }

});