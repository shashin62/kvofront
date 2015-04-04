var oTable;
$.fn.dataTableExt.oApi.fnReloadAjax = function (oSettings, sNewSource, myParams) {
    if (oSettings.oFeatures.bServerSide) {
        if (typeof sNewSource != 'undefined' && sNewSource != null) {
            oSettings.sAjaxSource = sNewSource;
        }
        oSettings.aoServerParams = [];
        oSettings.aoServerParams.push({"sName": "user",
            "fn": function (aoData) {
                for (var index in myParams) {
                    aoData.push({"name": index, "value": myParams[index]});
                }
            }
        });
        this.fnClearTable(oSettings);
        return;
    }
};
$(function () {
    oTable = $('#all_users').DataTable({
        "iDisplayLength": 20,
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": baseUrl + "/family/getAjaxSearch?type=transfer",
        
        "fnCreatedRow": function (nRow, aData, iDataIndex) {
             $('td:eq(5)', nRow).html('<a class="edit_row btn btn-xs btn-success insert" onclick="transferUser(' + aData[0] + ')" data-rowid=' + aData[0] + '><span class="glyphicon glyphicon-edit"></span>Transfer</a>');
        },
        "rowCallback": function (row, data) {
        },
        "fnInitComplete": function (oSettings, json) {
        }
    });
    

    $('#all_users').removeClass('display').addClass('table table-striped table-bordered');

    $(".search, .search_username").bind("keyup", function () {
        var table = $('#all_users').DataTable();
        table
                .column($(this).attr('custom'))
                .search($.trim(this.value))
                .draw();
    });
    
});

//$('.registerButton').click(function(){
//     var myArray = {         
//         "on": "onsubmit",
//         "bSearchable_1": $('.first_name').val(),
//         "bSearchable_2": $('.last_name').val(),
//         "bSearchable_3": $('.main_surname').val()
//     }
//     var oTable = $("#all_users").dataTable();
//        oTable.fnReloadAjax(oTable.oSettings, myArray);
//});
$('#all_users tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');

        var row = oTable.row(tr);

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // Open this row
            row.child(format(row.data())).show();
            tr.addClass('shown');
        }
    });
    
    function transferUser(ownerId)
{
   
     $.ajax({
        url: baseUrl + '/family/transferUser',
        dataType: 'json',
        data: {id: id,ownergroupid:ownerId},
        type: "POST",
        success: function (response) {
            var displayMsg = response.message;
            showJsSuccessMessage(displayMsg);
            setTimeout(function () {
                $('.jssuccessMessage').hide('slow');
                window.location.href = baseUrl + '/family/details/' + gid;
                
            }, 2500);
        }
    });
    
}
