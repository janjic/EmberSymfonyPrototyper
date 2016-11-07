import Ember from 'ember';

export default Ember.Component.extend({

    store: Ember.inject.service(),

    didInsertElement: function () {

        var names = ["id", "name", "description", "editAction"];
        var colModel =[
            { name : 'id', index:'id', sortable:true, searchoptions: {
                sopt: ['eq', 'ne', 'nu', 'nn']
            }},
            { name : 'username', index : 'username', searchoptions: {
                sopt: ['eq', 'ne', 'bw', 'bn', 'ew','en','cn','nc','nu','nn']
            } },
            { name : 'email', index : 'description', searchoptions: {
                sopt: ['eq', 'ne', 'bw', 'bn', 'ew','en','cn','nc','nu','nn']
            } },
            { name : 'editAction',sortable:false, editable : false, width:40,search:false, formatter: function(cellvalue, options) {
                var id = options.rowId;
                return "<a href='#' class='btn btn-xs btn-default btn-quick'><i class='fa fa-pencil'></i></a>";
            }}];

        setUpjQgrid('grid', 'https://192.168.11.3/app_dev.php/api/usersJqgrid', 'All Users', names, colModel, '');
        // $("#grid").jqGrid('setGridParam', {ondblClickRow: function(rowid,iRow,iCol,e){alert('double clicked');}});

    }
});
