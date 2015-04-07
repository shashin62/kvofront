$(document).ready(function () {

 $("#UserLoginForm").validate({
        errorElement: "span",
rules: {
            'data[People][mobile_number]': {
                required: true
            },
            'data[People][password]': {
                required: true
            }
        },
          messages: {
            'data[People][mobile_number]': {
                required: 'Please enter mobile number'
            },
            'data[People][password]': {
                required: 'Please enter password'
            }
        }
    });

    $("#registerUser").validate({
        errorElement: "span",
        rules: {
            'data[first_name]': {
                required: true,
                maxlength: 25
            },
            'data[last_name]': {
                required: true,
                maxlength: 25
            },
            'data[phone_number]': {
                required: true,
                maxlength: 10
            },
            'data[email]': {
                required: true,
                email: true
            },            
            'data[date_of_birth]': {
                required: true
            }
        },
        messages: {
            'data[first_name]': {
                required: 'Please enter first name',
                maxlength: 'Length exceeds 25 charaters'
            },
            'data[last_name]': {
                required: 'Please enter last name',
                maxlength: 'Length exceeds 25 charaters'
            },
            'data[phone_number]': {
                required: 'Please enter phone',
                maxlength: 'Please enter valid phone number'
            },
            'data[email]': {
                required: 'Please enter email',
                email: 'Please enter valid email',
            },           
            'data[gender]': {
                required: 'Please select gender'
            },
            'data[date_of_birth]': {
                required: 'Please select DOB'
            }
        },
        submitHandler: function (form) {
            var queryString = $('#registerUser').serialize();

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
                setTimeout(function () {
                    $('.jssuccessMessage').hide('slow');
                    window.location.href = baseUrl + "/user/login";
                }, 2500);
            }
               
            }, "json");
        
            return false;
        }
    });
    
    $.validator.addMethod("atleastone", function(value, element) {
        if ($('#mobile_number').val() == '' && $('#email_address').val() == '') {
            return false;
        }
        return true;
    }, "Please enter at least one of these fields");
    
    
     $("#ForgotForm").validate({
        errorElement: "span",
        rules: {
            'data[mobile_number]': {
                maxlength: 25
            
            },
            'data[email_address]': {
                atleastone: true
            
            }
        },
        messages: {
            'data[mobile_number]': {
                maxlength: 'Please enter valid phone number'
            }
           
        },
        
        submitHandler: function (form) {
            var queryString = $('#ForgotForm').serialize();

            $.post(baseUrl + '/user/doResendPin', queryString, function (data) {
                 if (0 == data.status) {
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
                    window.location.href = baseUrl + "/user/login";
                }, 2500);
            }
               
            }, "json");
        
            return false;
        }
    });
});

$(".registerButton").click(function () {
    $("#registerUser").submit();
    return false;
});

$(".signin").click(function () {
    $("#UserLoginForm").submit();
    return false;
});

$('.forgot').click(function(){
     $("#ForgotForm").submit();
    return false;
});