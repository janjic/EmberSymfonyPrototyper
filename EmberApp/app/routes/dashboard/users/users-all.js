import Ember from 'ember';
export default Ember.Route.extend({
    model: function () {
        return {
            colModel:[
                { name : 'id', index:'id', width: 90, sortable:true },
                { name : 'username', index : 'username' },
                { name : 'firstName', index : 'firstName' },
                { name : 'lastName', index : 'lastName' },
                { name : 'enabled', index : 'enabled', width:100, stype: "select", searchoptions: {
                    sopt: ['eq', 'ne'], value: "-1:"+'ALL'+";1:"+'YES'+";0:"+'NO'
                }, formatter:function isEnabled (cellvalue, options, rowObject)
                {
                    return cellvalue?"<span class='fa fa-check' aria-hidden='true'></span>":"<span class='fa fa-close' aria-hidden='true'></span>";
                } },
                { name : 'locked', index : 'locked', width:100, stype: "select", searchoptions: {
                    sopt: ['eq', 'ne'], value: "-1:"+"ALL"+";1:"+"YES"+";0:"+'NO'
                },formatter:function isLocked (cellvalue, options, rowObject)
                {
                    return cellvalue?"<span class='fa fa-check' aria-hidden='true'></span>":"<span class='fa fa-close' aria-hidden='true'></span>";
                } },
                { name : 'editAction',sortable:false, editable : false, width:40, search:false, formatter: function(cellvalue, options) {
                    var id = options.rowId;
                    return "<a href=# class='btn btn-xs btn-default btn-quick'><i class='fa fa-pencil'></i></a>";
                }
                }
            ],
            colNames: ['ID', 'Username', 'First Name', 'Last Name','Enabled', 'Locked', ''],
            route: 'https://192.168.11.3/app_dev.php/api/users-jqgrid'
        }
    }
});
