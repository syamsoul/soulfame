
function formAddData(){
    var sdfm = $('#sdFormModal');
    clearForm(sdfm[0]);
    sdfm.find('.modal-title').html(sdfm.find('.modal-title').attr("data-add-title"));
    sdfm.find('#sdMainForm').find('input#password').attr("placeholder", "Password");
    sdfm.find('.saveBtn').attr("onclick", "saveData('#sdFormModal');");
    sdfm.modal('show');
}

function saveData(el, xid=false){
    var action = !xid ? "create" : "update";
    var sdfm = $(el);
    var data = {action:action};
    if(xid !== false) data.xid = xid;

    sdfm.find('input[data-copy-to], select[data-copy-to]').each(function(ind, val){
        $($(val).attr("data-copy-to")).val($(val).val());
    });

    $.extend(data, sdfm.find('#sdMainForm').serializeObject());
    $.ajax({
        url: "",
        method: "POST",
        data: data
    }).done(function(res){
        try{
            res = JSON.parse(res);
            toastrArr(res.msg);
            getData();
            $('#sdFormModal').modal('hide');
        }catch(ex){
            toastr['error'](res);
            sdfm.find('input[data-copy-to], select[data-copy-to]').each(function(ind, val){
                $($(val).attr("data-copy-to")).val("");
            });
        }
    });
}

function getData(xid=null, execFunc=null){
    if(xid != null){
        $.ajax({
            url: "",
            method: "POST",
            data: {action:"get", xid:xid}
        }).done(function(res){
            try{
                res = JSON.parse(res);
                var sdfm = $('#sdFormModal');
                clearForm(sdfm[0]);
                sdfm.find('.modal-title').html(sdfm.find('.modal-title').attr("data-edit-title"));
                sdfm.find('.editForm-hidden').hide();
                sdfm.find('#sdMainForm').deserialize(res);
                sdfm.find('#sdMainForm').find('input#password').attr("placeholder", "Leave blank to keep current password");
                sdfm.find('.saveBtn').attr("onclick", "saveData('#sdFormModal', true);");
                sdfm.find('.select2').trigger('change');
                sdfm.modal('show');
                if(execFunc != null) execFunc();
            }catch(exception){
                toastr['error'](res);
            }
        });
    }else{
        $.ajax({
            url: "",
            method: "POST",
            data: {action:"get"}
        }).done(function(res){
            try{
                res = JSON.parse(res);
                refreshDatatable(function(){
                    $('#sdDataTable').find('tbody').html(res.htmlstr);
                });
                if(execFunc != null) execFunc(res);
            }catch(exception){
                toastr['error'](res);
            }
        });
    }
}

function deleteData(xid){
    if(xid != null){
        swal({
            title: 'Are you sure?',
            text: "This will delete the item and you won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, remove it!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "",
                    method: "POST",
                    data: {action:"delete", xid:xid}
                }).done(function(res){
                    try{
                        res = JSON.parse(res);
                        toastrArr(res.msg);
                        getData();
                    }catch(ex){
                        toastr['error'](res);
                    }
                });
            }
        });
    }
}

function refreshDatatable(runBefore=null){

    var tbl = $('#sdDataTable');

    if($.fn.dataTable.isDataTable(tbl) == true) tbl.dataTable().fnDestroy();

    if(runBefore != null) runBefore();

    tbl.dataTable( {
        responsive: false,
        "aoColumnDefs": [{ 'bSortable': false, 'aTargets': [ -1 ] }],
        "oLanguage": { "oPaginate": {"sPrevious": "", "sNext": ""}, "sSearch":"" },
        "iDisplayLength": 10,
        "aLengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
        "dom": '<"row"<"col-md-8"Tl><"col-md-4"dafrB>><"clearfix">tip',
        "buttons": [
            {
                extend: 'print',
                className: 'btn-sm btn-primary',
                init: function(api, node, config) {
                    $(node).removeClass('btn-default');
                },
                text: 'Print'
            }
        ],
    });

    $('.dataTables_filter input').attr("placeholder", "Enter Filter Terms Here....");
}

function clearForm(el){
    $(el).find('input, textarea').val("");
    $(el).find('select').each(function(ind, val){
        $(val).val($(val).find('option').first().attr("value"));
    });
    $(el).find('.select2').trigger('change');
    $(el).find('.saveBtn').off('click');
}
