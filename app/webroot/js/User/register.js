$(document).ready(function () {

    $("#registerUser").validate({
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
            'data[User][phone_number]': {
                required: true,
                maxlength: 10
            },
            'data[User][email]': {
                required: true,
                email: true
            },
            'data[User][password]': {
                required: true,
                minlength : 6
            },
            'data[User][confirm_password]': {
                required: true,
                equalTo: "#password"
            },
            'data[User][gender]': {
                required: true
            },
            'data[User][date_of_birth]': {
                required: true
            }
            
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
            'data[User][phone_number]': {
                required: 'Please enter phone',
                maxlength: 'Please enter valid phone number'
            },
            'data[User][email]': {
                required: 'Please enter email',
                email: 'Please enter valid email',
            },
            'data[User][password]': {
                required: 'Please provide a password',
                minlength:"Please enter at least 6 characters."  
            },
            'data[User][confirm_password]': {
                required: 'Please reenter password',
                 equalTo: "Please enter the same password as above" 
            },
            'data[User][gender]': {
                required: 'Please select gender'
            },
            'data[User][date_of_birth]': {
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
});

$(".registerButton").click(function () {
    $("#registerUser").submit();
    return false;
});