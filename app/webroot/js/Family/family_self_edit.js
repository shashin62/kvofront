$(document).ready(function () {
    
    var hcurrentwidth;
    var hcurrentheight;
    var huserImagePath; 

    $('.selectpicker').selectpicker();

    $(".combobox").combobox();
    $(".combobox1").combobox();
    late(is_late);
    console.log(userType);
    if (gender == 'female') {
        showmaidensurname('Female');
        showmaidenvillage('Female');
    } else if (userType == 'addfather') {
        showmaidensurname('Male');
        showmaidenvillage('Male');
    } else {
        showmaidensurname('Male');
        showmaidenvillage('Male');
    }

    $("#createFamily").validate({
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
            'sect': {
                required: true,
                maxlength: 25
            },
            'gender': {
                required: true,
                maxlength: 25
            },
            'martial_status': {
                required: true,
                maxlength: 25
            },
            'data[People][first_name]': {
                required: true,
                maxlength: 25
            },
            'data[People][last_name]': {
                required: true,
                maxlength: 25
            },
            'data[People][mobile_number]': {
                required: true,
                maxlength: 10
            },
            'data[People][email]': {
                required: false,
                email: true
            },
            'data[People][village]': {
                required: true
            },
            'data[People][main_surname]': {
                required: true
            },
        },
        messages: {
            'sect': {
                required: 'Please select sect',
            },
            'gender': {
                required: 'Please select gender',
            },
            'martial_status': {
                required: 'Please select martial status',
            },
            'data[People][first_name]': {
                required: 'Please enter first name',
                maxlength: 'Length exceeds 25 charaters'
            },
            'data[People][last_name]': {
                required: 'Please enter last name',
                maxlength: 'Length exceeds 25 charaters'
            },
            'data[People][mobile_number]': {
                required: 'Please enter phone number',
                maxlength: 'Please enter valid phone number'
            },
            'data[People][email]': {
                email: 'Please enter valid email',
            },
            'data[People][village]': {
                required: 'Please select village'
            },
            'data[People][main_surname]': {
                required: 'Please select main surname',
            },
        },
        submitHandler: function (form) {
            $('.editOwnButton').attr('disabled','disabled');
            var queryString = $('#createFamily').serialize();
            queryString += '&data[People][village]=' + $('.villagediv').find('.ui-autocomplete-input').val();
            queryString += '&data[People][main_surname]=' + $('.main_surnamediv').find('.ui-autocomplete-input').val();
            queryString += '&data[People][maiden_surname]=' + $('.maidensurname').find('.ui-autocomplete-input').val();
            queryString += '&data[People][maiden_village]=' + $('.maidenvillage').find('.ui-autocomplete-input').val();
            queryString += '&data[People][blood_group]=' + $('.blood_groupdiv').find('.ui-autocomplete-input').val();
            queryString += '&data[People][education_1]=' + $('.education1_div').find('.ui-autocomplete-input').val();
            queryString += '&data[People][education_2]=' + $('.education2_div').find('.ui-autocomplete-input').val();
            queryString += '&data[People][education_3]=' + $('.education3_div').find('.ui-autocomplete-input').val();
            queryString += '&data[People][education_4]=' + $('.education4_div').find('.ui-autocomplete-input').val();
            queryString += '&data[People][education_5]=' + $('.education5_div').find('.ui-autocomplete-input').val();


            var type = userType;
            var peopleid = pid;
            var groupid = grpid;

            $.post(baseUrl + '/family/editOwnDetails?type=' + type + '&peopleid=' + peopleid + '&gid=' + groupid, queryString, function (data) {
                if (0 == data.status) {
                    if (data.error.name.length > 0) {
                        for (var i = 0; i < data.error.name.length; i++) {
                            displayErrors(data.error.name[i], $("#" + data.error.name[i]).attr('type'), data.error.errormsg[i], "server");
                        }
                    }
                      $('.editOwnButton').attr('disabled',false);
                } else {
                       $('.editOwnButton').attr('disabled','disabled');
                    var displayMsg = data.message;
                    showJsSuccessMessage(displayMsg);
                    setTimeout(function () {
                        $('.jssuccessMessage').hide('slow');

                        if (grpid == '') {
                            grpid = data.grpid;
                        }
                        
                        if( module == 'tree') {
                            window.location.href = baseUrl + "/tree/?gid=" + grpid+'&token=9daa9b2f09c22636b56d33786a270af';
                        } else {
                            window.location.href = baseUrl + "/family/details/" + grpid;
                        }
                        
                    }, 2500);
                }

            }, "json");

            return false;
        }
    });



    var button2 = $('#uploadButton'), interval2;
    var upload2 = new AjaxUpload(button2, {
        action: baseUrl + '/image/uploadimage?pid=' + pid,
        name: 'image',
        titleText: 'Upload Logo',
        onSubmit: function (file, ext) {

            var ext = ext.toString().toLowerCase();
            var regexp1 = new RegExp("^(" + image_format + ")$");

            if (ext && regexp1.test(ext)) {
                // show the loader in place of button
                // button2.html('<span>Uploading...</span>');
                /* If you want to allow uploading only 1 file at time,
                 you can disable upload button*/
                //this.disable();
                /* Uploding -> Uploading. -> Uploading...*/
//                        interval2 = window.setInterval(function(){
//                            var text = button2.html();
//                            if (text.length < 13){
//                                button2.html(text + '.');
//                            } else {
//                                button2.html('<span>Uploading...</span>');
//                            }
//                        }, 200);


            } else {
                var displayMsg = image_upload_error;
                displayTopSuccessMessage(displayMsg, 'imessage');
                return false;
            }
        },
        onComplete: function (file, response) {
            response = jQuery.parseJSON(response);

            if (response.success == 0) {
                displayTopSuccessMessage(response.message, 'imessage');
                return false;
            }
            hcurrentwidth = response.width;
            hcurrentheight = response.height;
            huserImagePath = response.userImagePath;



            var docHeight = $(document).height();

            vUrl = baseUrl + '/image/cropImage?pid=' + pid;
            $("#overlay")
                    .show()
                    .fadeIn()
                    .height(docHeight);
            $("#postview").load(vUrl, function () {
                var d = new Date();
                var n = Math.random();
                $('#thumbnail').attr('src', baseUrl + '/' + response.userImagePath + '?q=' + n);
                $('#thumbPreview').attr('src', baseUrl + "/" + response.userImagePath + '?q=' + n);
                createThumbPreview();
                var selectionObject = {};
                var newW = 346;
                if (hcurrentwidth > newW) {
                    newW = 346;
                } else {
                    newW = hcurrentwidth;
                }

                var newH = 346;
                if (hcurrentheight > newH) {
                    newH = 346;
                } else {
                    newH = hcurrentheight;
                }

                if (newH > newW) {
                    newH = newW;
                }
                if (newW > newH) {
                    newW = newH;
                }
                selectionObject.height = 100;
                selectionObject.width = 100;
                selectionObject.x1 = 0;
                selectionObject.x2 = 100;
                selectionObject.y1 = 1;
                selectionObject.y2 = 101;

                preview('', selectionObject);


            });
            $("#remove_image").show();
            $('.editPhoto').attr('title', 'Edit');
        }

    });

});

$(".editOwnButton").click(function () {
    //console.log(  $('.villagediv').find('.ui-autocomplete-input').val());return;
    if (typeof $('.main_surname ').val() == 'object') {
        $('.main_surname').rules('remove', 'required');
    }
    if (typeof $('.village ').val() == 'object') {
        $('.village').rules('remove', 'required');
    }

    if (userType == 'addnew' && $("#PeopleIsLate").is(':checked') == true) {
        $('.phone_number').rules('remove', 'required');
        $('.martial_status').rules('remove', 'required');
    } else {
        $('.phone_number').rules('add', 'required');
        $('.martial_status').rules('add', 'required');
    }
    if (userType != 'addnew') {
        $('.phone_number').rules('remove', 'required');
    }
    if ($("#PeopleIsLate").is(':checked') == false) {
        $('.date_of_death').rules('remove', 'required');
    }

    $("#createFamily").submit();
    return false;
});

$('.genders > label').click(function ()
{
    showmaidensurname($(this).text());
    showmaidenvillage($(this).text());
});

function showmaidensurname($this)
{

    if ($.trim($this) == "Male") {
        $(".maidensurname").hide();
    } else {
        $(".maidensurname").show();
    }
}
function showmaidenvillage($this)
{

    if ($.trim($this) == "Male") {
        $(".maidenvillage").hide();
    } else {
        $(".maidenvillage").show();
    }
}
$(".male").click(function () {
    $(".maidensurname").hide();
    $(".widower").val('widower');

    return false;
});

$(".female").click(function () {
    $(".maidensurname").show();
    $(".widower").val('widow');
    return false;
});

$("#PeopleIsLate").click(function () {

    late();
});

function late(is_late) {

    if ($("#PeopleIsLate").is(':checked') == true || is_late == 1) {
        $(".sameaddress").hide();
        $(".dd").show();
        //$('.date_of_death').rules('add', 'required');
    } else {
        $(".sameaddress").show();
        $(".dd").hide();

        //$('.date_of_death').rules('remove', 'required');
    }
}

function createThumbPreview()
{
    imageAreaselectDefault = 10;
    var t = '1:1';
    var newW = imageAreaselectDefault;

    if (hcurrentwidth > newW) {
        newW = imageAreaselectDefault;
    } else {
        newW = hcurrentwidth;
    }

    var newH = imageAreaselectDefault;
    if (hcurrentheight > newH) {
        newH = imageAreaselectDefault;
    } else {
        newH = hcurrentheight;
    }

    if (newH > newW) {
        newH = newW;
    }
    if (newW > newH) {
        newW = newH;
    }

    $('#thumbnail').imgAreaSelect({
        parent:$('#parent'),
        handles: true,
        aspectRatio: t,
        x1: 0, 
        y1: 1, 
        x2: 100, 
        y2: 101,
        show:true,
        onSelectChange: preview

    });

    $('.publishFansPopup').css('height', newH + 'px');
}

function preview(img, selection)
{
    
    var scaleX = 120 / selection.width;
    var scaleY = 120 / selection.height;
    var currentwidth = parseInt(hcurrentwidth);
    var currentheight = parseInt(hcurrentheight);

    $('#huserThumbImagePath').val(huserThumbImagePath);
    $('#huserImagePath').val(huserImagePath);
    $('#filePath').val(filePath);
    $('#thumbPreview').css('width', Math.round(scaleX * currentwidth) + 'px');
    $('#thumbPreview').css('height', Math.round(scaleY * currentheight) + 'px');
    $('#thumbPreview').css('marginLeft', '-' + Math.round(scaleX * selection.x1) + 'px');
    $('#thumbPreview').css('marginTop', '-' + Math.round(scaleY * selection.y1) + 'px');

    $('#x1').val(selection.x1);
    $('#y1').val(selection.y1);
    $('#x2').val(selection.x2);
    $('#y2').val(selection.y2);
    $('#w').val(selection.width);
    $('#h').val(selection.height);
}
