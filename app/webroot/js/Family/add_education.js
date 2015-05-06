var oTable;
$(function () {

    oTable = $('#all_degrees').dataTable({
        "bPaginate":false,
        "bFilter":false,
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": baseUrl + "/family/getAjaxEducationData?people_id="+$('#people_id').val(),
        "fnCreatedRow": function (nRow, aData, iDataIndex) {
            $('td:eq(8)', nRow).html('<a class="edit_row btn btn-xs btn-success" onclick="editEducation(' + aData[0] + ', \'' + aData[1] + '\', \''+aData[2]+ '\', \''+aData[3]+ '\', \''+aData[4]+ '\', \''+aData[5]+ '\', \''+aData[6]+ '\', \''+aData[7]+'\')" data-rowid=' + aData[0] + '><span class="glyphicon glyphicon-edit"></span>Edit</a> \n\
<a class="delete_row btn btn-xs btn-danger" onclick="deleteEducation(' + aData[0] + ')" data-rowid=' + aData[0] + '><span class="glyphicon glyphicon-trash">Delete</a>');
            if (parseInt(aData[6]) > 0) {
                $('td:eq(6)', nRow).html(aData[6]+'%');
            }
        },
        "rowCallback": function (row, data) {

        },
        "fnInitComplete": function (oSettings, json) {

        }
    });
    $('#all_degrees').removeClass('display').addClass('table table-striped table-bordered');
});

function editEducation(id, name, inst, unv, sp, yr, per, pf) {
    $('#name').val(name);
    $('#name option[value="'+name+'"]').attr("selected","selected");
    $('#institution_name').val(inst);
    $('#university_name').val(unv);
    $('#area_specialization').val(sp);
    $('#year_of_passing').val(yr);
    $('#percentage').val(per);
    $('#part_full_time').val(pf);
    $("#part_full_time_"+pf.toLowerCase()).prop("checked", true);
    $('#id').val(id);    
}

function reset() {
    $('#name').val('');
    $('#institution_name').val('');
    $('#university_name').val('');
    $('#area_specialization').val('');
    $('#year_of_passing').val('');
    $('#percentage').val('');
    $('#part_full_time_part').prop("checked", false);
    $('#part_full_time_full').prop("checked", false);
    $('#id').val('');    
}

function deleteEducation(id)
{

    $.ajax({
        url: baseUrl + '/family/deleteEducation',
        dataType: 'json',
        data: {id: id},
        type: "POST",
        success: function (response) {
            var displayMsg = response.message;
            showJsSuccessMessage(displayMsg);
            setTimeout(function () {
                $('.jssuccessMessage').hide('slow');
                oTable.fnDraw(true);
            }, 2500);


        }
    });
}


$(document).ready(function () {
    
    
    
    $("#educationForm").validate({
        errorElement: "div",
          errorPlacement: function(error, element) {
               var type = $(element).attr("type");
               
            if (typeof type == 'undefined' ) {
                error.appendTo(element.parent());
            } else if(  type == 'radio' ) {
                error.appendTo(element.parent().parent());
            }
            else {
                error.insertAfter(element);
            }
        },
        rules: {
            'data[PeopleEducation][name]': {
                required: true,
            },
            'data[PeopleEducation][institution_name]': {
                required: true
            },
            'data[PeopleEducation][year_of_passing]': {
                required: true,
                number: true
            },
            'data[PeopleEducation][percentage]': {
                number: true
            },
            'data[PeopleEducation][part_full_time]': {
                required: true
            }
        },
        messages: {
           'data[PeopleEducation][name]': {
                required: 'Please select a degree'
            },
            'data[PeopleEducation][institution_name]': {
                required: 'Please enter name of institute'
            },
            'data[PeopleEducation][year_of_passing]': {
                required: 'Please enter year of passing'
            },
            'data[PeopleEducation][part_full_time]': {
                required: 'Please select Full Time/Part Time'
            }
        },
        submitHandler: function (form) {
            var queryString = $('#educationForm').serialize();
            
            $.post(baseUrl + '/family/addEducation', queryString, function (data) {
            if (0 == data.success) {
                if (data.error.name.length > 0) {
                    for (var i = 0; i < data.error.name.length; i++) {
                        displayErrors(data.error.name[i], $("#" + data.error.name[i]).attr('type'), data.error.errormsg[i], "server");
                    }
                }
            } else {
                var displayMsg = data.message;
                showJsSuccessMessage(displayMsg);
                setTimeout(function () {
                    $('.jssuccessMessage').hide('slow');
                    $('#id').val(''); 
                    reset();
                    oTable.fnDraw(true);
                }, 2500);
            }
            }, "json");
            return false;
        }
    });
});

$(".addnew").click(function () {
    $("#educationForm").submit();
    return false;
});

$(".cancel").click(function () {
    reset();
    window.location.href = baseUrl + '/family/details/'+$('#group_id').val();
    return false;
});
