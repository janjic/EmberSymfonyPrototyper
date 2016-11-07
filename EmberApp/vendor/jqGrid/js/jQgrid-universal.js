function setUpjQgrid(id, dataRoute, caption, colNames, colModel, deleteRoute){

    $("#gs_product_name").val(localStorage.getItem('search'));
    var search = localStorage.getItem('search');
    //console.log("MODEL IN SETUP", colModel);
    var jQgrid = $('#'+id);
    jQgrid.jqGrid({
        url: dataRoute+(localStorage.getItem('search')?"?search="+localStorage.getItem('search'):""),
        datatype : "json",
        mtype: 'POST',
        height : 'auto',
        jsonReader : {
            root: "items",
            page: "description.current",
            total: "description.pageCount",
            records: "description.totalCount",
            repeatitems: true,
            cell: "cell",
            id: "id",
            userdata: "userdata",
            subgrid: {root:"items",
                repeatitems: true,
                cell:"cell"
            }
        },
        colNames: colNames,
        colModel: colModel,
        rowNum : 10,
        rowList : [10, 20, 30],
        pager : '#jqGridPager',
        sortname : 'id',
        toolbarfilter: true,
        viewrecords : true,
        sortorder : "asc",
        gridComplete: function(){
            var ids = jQgrid.jqGrid('getDataIDs');
            for(var i=0;i < ids.length;i++){
                var cl = ids[i];
                be = "<button class='btn btn-xs btn-default btn-quick' title='Edit Row' onclick=\"$('#jqgrid').editRow('"+cl+"');\"><i class='fa fa-pencil'></i></button>";
                se = "<button class='btn btn-xs btn-default btn-quick' title='Save Row' onclick=\"$('#jqgrid').saveRow('"+cl+"');\"><i class='fa fa-save'></i></button>";
                ca = "<button class='btn btn-xs btn-default btn-quick' title='Cancel' onclick=\"$('#jqgrid').restoreRow('"+cl+"');\"><i class='fa fa-times'></i></button>";
                jQgrid.jqGrid('setRowData',ids[i],{act:be+se+ca});

            }
        },
        loadComplete: function(){
            localStorage.removeItem('search');
            jQgrid.jqGrid('setGridParam',{url:dataRoute+(localStorage.getItem('search')?"?search="+localStorage.getItem('search'):"")}).trigger('reloadGrid');

        },
        editurl : "clientArray",
        caption : caption,
        multiselect : true,
        autowidth: true,
        beforeRequest: function() {
            responsive_jqgrid($('.jqGrid'));
        }
    });

    //enable datepicker
    function pickDate( cellvalue, options, cell ) {
        setTimeout(function(){
            $(cell) .find('input[type=text]')
                .datepicker({format:'yyyy-mm-dd' , autoclose:true});
        }, 0);
    }

    function responsive_jqgrid(jqgrid) {
        jqgrid.find('.ui-jqgrid').addClass('clear-margin span12').css('width', '');
        jqgrid.find('.ui-jqgrid-view').addClass('clear-margin span12').css('width', '');
        jqgrid.find('.ui-jqgrid-view > div').eq(1).addClass('clear-margin span12').css('width', '').css('min-height', '0');
        jqgrid.find('.ui-jqgrid-view > div').eq(2).addClass('clear-margin span12').css('width', '').css('min-height', '0');
        jqgrid.find('.ui-jqgrid-sdiv').addClass('clear-margin span12').css('width', '');
        jqgrid.find('.ui-jqgrid-pager').addClass('clear-margin span12').css('width', '');
    }

    function formatEditButton(){
        return "<button class='btn btn-xs btn-default btn-quick'><i class='fa fa-pencil'></i></button>";
    }


    var navPagerDeleteOptions = null;

    if(deleteRoute == undefined){
        navPagerDeleteOptions = {
            closeAfterAdd: true,
            closeAfterEdit: true
        }
    }else{
        navPagerDeleteOptions = {
            closeAfterAdd: true,
            closeAfterEdit: true,
            url: '#'
        }
    }
    jQgrid.jqGrid('navGrid', "#jqGridPager", {
            edit : false,
            add : false,
            del : true,
            search: false
        },{
            closeAfterAdd:true,
            closeAfterEdit: true
        },
        {
            closeAfterAdd:true,
            closeAfterEdit: true
        },navPagerDeleteOptions);

    /**
     *  SUCCESS FUNCTION FOR AJAX DELETE REQUEST
     * @param ctx
     * @param data
     */
    var deleteSuccessFunction = function(ctx, data) {
        if(data != "404"){
            ctx.forEach(function (rowID) {
                //console.log("ROWID IN CALLBACK FUN",rowID);
                jQgrid.jqGrid('delRowData',rowID);
            });
        }else{
            triggerModal("Error while deleting item", MODAL_ERROR);
        }
    };

    jQgrid.jqGrid('inlineNav', "#jqGridPager");

    jQgrid.jqGrid('filterToolbar',{stringResult: true, searchOnEnter: false, defaultSearch : "cn"});


    // /* Add tooltips */
    // $('.navtable .ui-pg-button').tooltip({
    //     container : 'body'
    // });

    // Get Selected ID's
    $("a.get_selected_ids").bind("click", function() {
        s = jQgrid.jqGrid('getGridParam', 'selarrrow');
        alert(s);
    });

    // Select/Unselect specific Row by id
    $("a.select_unselect_row").bind("click", function() {
        jQgrid.jqGrid('setSelection', "13");
    });

    // Select/Unselect specific Row by id
    $("a.delete_row").bind("click", function() {
        var su = jQgrid.jqGrid('delRowData',1);
        if(su) alert("Succes. Write custom code to delete row from server"); else alert("Already deleted or not in list");
    });

    jQgrid.bind("jqGridInlineEditRow", function() {
    });


    // // On Resize
    // $(window).resize(function() {
    //
    //     if(window.afterResize) {
    //         clearTimeout(window.afterResize);
    //     }
    //
    //     window.afterResize = setTimeout(function() {
    //
    //         /**
    //          After Resize Code
    //          .................
    //          **/
    //
    //         jQgrid.jqGrid('setGridWidth', $(".ui-jqgrid").parent().width());
    //
    //     }, 500);
    //
    // });

    // ----------------------------------------------------------------------------------------------------

    /**
     @STYLING
     **/
    $(".ui-jqgrid").removeClass("ui-widget ui-widget-content");
    $(".ui-jqgrid-view").children().removeClass("ui-widget-header ui-state-default");
    $(".ui-jqgrid-labels, .ui-search-toolbar").children().removeClass("ui-state-default ui-th-column ui-th-ltr");
    $(".ui-jqgrid-pager").removeClass("ui-state-default");
    $(".ui-jqgrid").removeClass("ui-widget-content");

    $(".ui-jqgrid-htable").addClass("table table-bordered table-hover");
    $(".ui-pg-div").removeClass().addClass("btn btn-sm btn-primary");
    //$(".ui-icon.ui-icon-plus").removeClass().addClass("fa fa-plus");
    $(".ui-icon.ui-icon-plus").parent().parent().remove();
    //$(".ui-icon.ui-icon-pencil").removeClass().addClass("fa fa-pencil");
    $(".ui-icon.ui-icon-pencil").parent().parent().remove();
    //$(".ui-icon.ui-icon-pencil").remove();
    $(".ui-icon.ui-icon-trash").removeClass().addClass("fa fa-trash-o");
    $(".ui-icon.ui-icon-search").removeClass().addClass("fa fa-search");
    $(".ui-icon.ui-icon-refresh").removeClass().addClass("fa fa-refresh");
    //$(".ui-icon.ui-icon-disk").removeClass().addClass("fa fa-save").parent(".btn-primary").removeClass("btn-primary").addClass("btn-success");
    $(".ui-icon.ui-icon-disk").parent().parent().remove();
    //$(".ui-icon.ui-icon-cancel").removeClass().addClass("fa fa-times").parent(".btn-primary").removeClass("btn-primary").addClass("btn-danger");
    $(".ui-icon.ui-icon-cancel").parent().parent().remove();

    $( ".ui-icon.ui-icon-seek-prev" ).wrap( "" );
    $(".ui-icon.ui-icon-seek-prev").removeClass().addClass("fa fa-backward");

    $( ".ui-icon.ui-icon-seek-first" ).wrap( "" );
    $(".ui-icon.ui-icon-seek-first").removeClass().addClass("fa fa-fast-backward");

    $( ".ui-icon.ui-icon-seek-next" ).wrap( "" );
    $(".ui-icon.ui-icon-seek-next").removeClass().addClass("fa fa-forward");

    $( ".ui-icon.ui-icon-seek-end" ).wrap( "" );
    $(".ui-icon.ui-icon-seek-end").removeClass().addClass("fa fa-fast-forward");


    return $('#'+id);
}
