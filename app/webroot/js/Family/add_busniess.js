$(document).ready(function () {
    $(".statescombo").combobox({width: '180px'});
    $(".combobox").combobox({width: '100px'});

    showoccupation(occupation);
    $("#addressForm").validate({
        errorElement: "div",
        errorPlacement: function (error, element) {
            var type = $(element).attr("type");

            if (typeof type == 'undefined') {
                error.appendTo(element.parent());
            } else if (type == 'radio') {
                error.appendTo(element.parent().parent());
            }
            else {
                error.insertAfter(element);
            }
        },
        rules: {
            'ownership_type': {
                required: true,
                maxlength: 25
            },
            'data[Address][road]': {
                required: false,
                maxlength: 25
            },
            'data[Address][suburb]': {
                required: false,
                maxlength: 25
            },
            'data[Address][city]': {
                required: true,
                maxlength: 25
            },
            'data[Address][state]': {
                required: false,
                maxlength: 25
            },
            'data[Address][zip_code]': {
                required: true,
                maxlength: 25
            },
        },
        messages: {
            'data[Address][road]': {
                required: 'Please enter road',
                maxlength: 'Length exceeds 25 charaters'
            },
            'data[Address][suburb]': {
                required: 'Please enter suburb',
                maxlength: 'Length exceeds 25 charaters'
            },
            'data[Address][city]': {
                required: 'Please enter city',
                maxlength: 'Length exceeds 25 charaters'
            },
            'data[Address][state]': {
                required: 'Please enter state',
                maxlength: 'Length exceeds 25 charaters'
            },
            'data[Address][zip_code]': {
                required: 'Please enter zip code',
                maxlength: 'Length exceeds 25 charaters'
            },
        },
        submitHandler: function (form) {
            var queryString = $('#addressForm').serialize();
            queryString += '&data[Address][suburb]=' + $('.suburbdiv').find('.ui-autocomplete-input').val();
            queryString += '&data[Address][state]=' + $('.statesdiv').find('.ui-autocomplete-input').val();

            var peopleid = pid;
            var addressid = aid;

            $.post(baseUrl + '/family/doProcessAddBusiness?peopleid=' + peopleid + '&addressid=' + addressid + '&parentid=' + prntid + '&paddressid=' + paddressid + '&gid=' + grpid, queryString, function (data) {
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
                        window.location.href = baseUrl + "/family/details/" + grpid;
                    }, 2500);
                }

            }, "json");

            return false;
        }
    });
});

$(".addressButton").click(function () {

  console.log($.trim($('.occupations > label.active').text()));
  
    if (typeof $('.state ').val() == 'object') {
        $('.state').rules('remove', 'required');
    }
    if (typeof $('.suburb ').val() == 'object') {
        $('.suburb').rules('remove', 'required');
    }
    var occupation = $.trim($('.occupations > label.active').text());
    var occupations = ['House Wife', 'Retired', 'Studying', 'Other'];
  
    if ($('.other:checked').val() != 'other' || $.inArray(occupation, occupations) !== -1) {

        $('.city').rules('remove', 'required');
        $('.zipcode').rules('remove', 'required');
        $('.state').rules('remove', 'required');
        $('.road').rules('remove', 'required');
        $('.suburb').rules('remove', 'required');

    }
    $("#addressForm").submit();
    return false;
});

//$('.same_as').click(function(){
//    if ( $(this).is(':checked') == true) {
//        $('.addresscontainer').hide();
//    } else {
//        $('.addresscontainer').show();
//    }
//});
function showoccupation($this)
{
    var occp;
    console.log($this);
    if (typeof occupation != 'undefined') {
        occp = occupation;
    } else {
        occp = $this;
    }

    var occupation = ['House Wife', 'Retired', 'Studying', 'Other'];
    if ($.inArray(occp, occupation) == -1) {
        $('.tohidecontainer').show();
    } else {
        $('.tohidecontainer').hide();
    }

}
$('.occupations > label').click(function () {
    showoccupation($.trim($(this).text()));
});
$('.other').click(function () {

    if ($(this).val() == 'other') {
        $('.addresscontainer').show();


    } else {
        $('.addresscontainer').hide();
    }
});
$('.same_ashomeaddress').click(function () {

    if ($(this).is(':checked') == true) {
        //$('.otherbusinessa').hide();
        $('.addresscontainer').hide();
        $('.other').attr('checked', false);
    } else {
        $('.otherbusinessa').show();
        $('.addresscontainer').show();
        $('.other').attr('checked', false);
    }
});




