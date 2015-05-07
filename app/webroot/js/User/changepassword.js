
 
    $("#changePassword").validate({
        errorElement: "span",
rules: {
            'data[People][old_pin]': {
                required: true
            },
            'data[People][pin]': {
                required: true,
                maxlength: 10,
                minlength: 5,
                number: true
            },
            'data[People][cpin]': {
                required: true,
                equalTo: '#pin'
            }
        },
          messages: {
            'data[People][old_pin]': {
                required: 'Please enter old password'
            },  
            'data[People][pin]': {
                required: 'Please enter new password',
                maxlength: 'Please enter no more than 10 digits',
                minlength: 'Please enter at least 5 digits',
            },
            'data[People][cpin]': {
                required: 'Please enter confirm password',
                equalTo: 'Password mismatch. Try again!'
            }
        },
        
        submitHandler: function (form) {
            var postData = $("#changePassword").serialize();
            $.post(baseUrl + '/user/changepassword', postData, function (data) {
                 if (0 == data.status) {
                    if (data.message.length > 0) {
                        showJsSuccessMessage(data.message);
                    }
                } else {
                     var displayMsg = data.message;
                    showJsSuccessMessage(displayMsg);
                    setTimeout(function () {
                        $('.jssuccessMessage').hide('slow');
                    }, 2500);
                }
               
            }, "json");
        
            return false;
        }
    });
    
    $('.changepwd').click(function () {
        $("#changePassword").submit();
        return false;
    });


