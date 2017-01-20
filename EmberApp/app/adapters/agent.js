import  ApplicationAdapter from './application';
export default ApplicationAdapter.extend({
    deleteRecord: function(store, type, snapshot) {
        let url = this.buildURL(type.modelName, snapshot.id, snapshot, 'deleteRecord');
        let data = {id: snapshot.id, newParent: snapshot.attr('newParentForDeleteId')};

        return this.ajax(url, "DELETE", {dataType: 'json', data: data});
    },
    shouldReloadRecord() {
        return true;
    }

});