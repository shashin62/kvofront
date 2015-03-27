var oTable;

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
