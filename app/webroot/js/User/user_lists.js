var oTable ;
$(function () {

    oTable = $('#getUsers').dataTable({
        "iDisplayLength": 20,
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": baseUrl + "/user/getUserAjaxData",
        "fnCreatedRow": function (nRow, aData, iDataIndex) {
            
            $('td:eq(6)', nRow).html('<a href="#" class="btn btn-xs btn-succes" >' + aData[6] + '</a>');
            $('td:eq(7)', nRow).html('<a class="edit_row btn btn-xs btn-success" \n\
onclick="editUser(' + aData[0] + ', \'' + aData + '\')" data-rowid=' + aData[0] + '><span class="glyphicon glyphicon-edit"></span>Edit</a> \n\
<a class="delete_row btn btn-xs btn-danger" onclick="deleteUser(' + aData[0] + ')" data-rowid=' + aData[0] + '><span class="glyphicon glyphicon-trash"></span>Delete</a>');

        },
        "rowCallback": function (row, data) {

        },
        "fnInitComplete": function (oSettings, json) {
           
        }
    });
    $('#getUsers').removeClass('display').addClass('table table-striped table-bordered');
});

 $("#addUser").validate({
     errorElement: "span",
      rules: {
            'data[User][first_name]': {
                required: true,
                maxlength: 25
            },
            'data[User][last_name]': {
                required: true,
                maxlength: 25
            },
            'data[User][email]': {
                required: true,
                email: true
            },
            'data[User][password]': {
                required: true,
                minlength : 6
            },
            'data[User][gender]': {
                required: true
            },
        },
         messages: {
            'data[User][first_name]': {
                required: 'Please enter first name',
                maxlength: 'Length exceeds 25 charaters'
            },
            'data[User][last_name]': {
                required: 'Please enter last name',
                maxlength: 'Length exceeds 25 charaters'
            },
            'data[User][email]': {
                required: 'Please enter email',
                email: 'Please enter valid email',
            },
            'data[User][password]': {
                required: 'Please provide a password',
                minlength:"Please enter at least 6 characters."  
            },
            'data[User][gender]': {
                required: 'Please select gender'
            },
        },
        submitHandler: function (form) {
            var queryString = $('#addUser').serialize();

            $.post(baseUrl + '/user/doRegisterUser', queryString, function (data) {
            if (0 == data.status) {
                if (data.error.name.length > 0) {
                    for (var i = 0; i < data.error.name.length; i++) {
                        displayErrors(data.error.name[i], $("#" + data.error.name[i]).attr('type'), data.error.errormsg[i], "server");
                    }
                }
            } else {
                var displayMsg = data.message;
                showJsSuccessMessage(displayMsg);
                $('.addUserForm').toggle('slow');
                setTimeout(function () {
                    $('.jssuccessMessage').hide('slow');
                    $('.userid').val('');
                    $('.first_name').val('');
                    $('.last_name').val('');
                    $('.gender').val('');
                    $('.email').val('');
                    $('.password').val('')
                    oTable.fnDraw(true);
                }, 1500);
            }


        }, "json");
        return false;
        }
 });
$(".bgButton").click(function () {
    $("#addUser").submit();
    return false;
});

$('.adduser').click(function() {
    $('.passwordField').show();
    $('.userid').val('');
    $('.addUserForm').toggle('slow');
});

function deleteUser(id)
{

    $.ajax({
        url: baseUrl + '/user/delete',
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

function editUser(id, adata)
{
    $('.passwordField').hide();
    $('.password').rules('remove', 'required');
    var aData = adata.split(',');
   
    $('.first_name').val(aData[1]);
     $('.last_name').val(aData[2]);
     $('.email').val(aData[3]);
     if (aData[4] == 'Male') {
         $('.gender').val('male');
     }
     if (aData[4] == 'Female') {
         $('.gender').val('female');
     }
     
    $('.userid').val(aData[0]);
   $('.addUserForm').show();
}

$('.email').keyup(function(){
        if($('.email').val().length >= 0) {
            $('span.error').css('display','none');
        } else {
            $('span.error').find('.error').css('display','block');
        }
    });
   