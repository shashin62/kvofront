var hcurrentwidth;
var hcurrentheight;
var huserImagePath;
var huserThumbImagePath;
var filePath;

$('.guju').click(function () {
window.location.href = baseUrl + '/family/details/'+ groupid + '?type=gujurathi';
});

$('.english').click(function () {
window.location.href = baseUrl + '/family/details/'+ groupid + '?type=english';
});

$('.hindi').click(function () {
window.location.href = baseUrl + '/family/details/'+ groupid + '?type=hindi';
});
$('.noteSave').click(function() {
    if( $.trim($('.comment').val()) == '') {
        return false;
    }
    var groupid = $(this).data('gid');
    var queryString = $('#addNote').serialize();
    $.post(baseUrl + '/family/addNote?gid=' + groupid, queryString, function (data) {
            if (0 == data.status) {
                if (data.error.name.length > 0) {
                    for (var i = 0; i < data.error.name.length; i++) {
                        displayErrors(data.error.name[i], $("#" + data.error.name[i]).attr('type'), data.error.errormsg[i], "server");
                    }
                }
            } else {
                var displayMsg = data.message;
                showJsSuccessMessage(displayMsg);
                $('.addNoteForm').toggle('slow');
                setTimeout(function () {
                    $('.jssuccessMessage').hide('slow');
                     $('.noteid').val('');
                    $('.comment').val('');
                    oTable.fnDraw(true);
                }, 2500);
            }
        }, "json");    
    
});
$('.addnote').click(function () {
    $('.noteid').val('');
    $('.addNoteForm').toggle('slow');
});

function profileOf(id) {
    doFormPost(baseUrl +"/search/index",'{ "id":"' + id + '"}');
}

$('.selfPhoto').click(function () {
    var $this = $(this);
    var id = $this.data('id');
    var gid = $this.data('gid');

    doFormPost(baseUrl + "/family/index?type=self&id=" + id + "&gid=" + gid, '{ "type":"self","fid":"' + id + '","gid":"' + gid + '"}');

});

/*$('.self').click(function () {
    var $this = $(this);
    var id = $this.data('id');
    var gid = $this.data('gid');

    doFormPost(baseUrl + "/family/index?type=self&id=" + id + "&gid=" + gid, '{ "type":"self","fid":"' + id + '","gid":"' + gid + '"}');

});*/

$('.editaddress').click(function () {

    var $this = $(this);
    var id = $this.data('id');
    var aid = $this.data('aid');
    var gid = $this.data('gid');

    doFormPost(baseUrl + "/family/addAddress?type=self&id=" + id + "&aid=" + aid + "&gid=" + gid,
            '{ "type":"self","fid":"' + id + '","aid":"' + aid + '","gid":"' + gid + '"}');

});

$('.editbusiness').click(function () {

    var $this = $(this);
    var id = $this.data('id');
    var aid = $this.data('aid');
    var gid = $this.data('gid');

    doFormPost(baseUrl + "/family/addBusiness?type=self&id=" + id + "&aid=" + aid + "&gid=" + gid,
            '{ "type":"self","fid":"' + id + '","aid":"' + aid + '","gid":"' + gid + '"}');

});


$('.addspouse').click(function () {

    var $this = $(this);
    var id = $this.data('id');
    var first_name = $this.data('first_name');
    var gid = $this.data('gid');
    doFormPost(baseUrl + "/family/searchPeople?type=addspouse",
            '{ "type":"addspouse","fid":"' + id + '","gid":"' + gid + '","name_parent":"' + first_name + '"}');
       
    
});

$('.addexspouse').click(function () {

    var $this = $(this);
    var id = $this.data('id');
    var first_name = $this.data('first_name');
    var gid = $this.data('gid');
    doFormPost(baseUrl + "/family/searchPeople?type=addexspouse",
            '{ "type":"addexspouse","fid":"' + id + '","gid":"' + gid + '","name_parent":"' + first_name + '"}');
       
    
});

$('.addfather').click(function () {

    var $this = $(this);
    var id = $this.data('id');
    var gid = $this.data('gid');
    var first_name = $this.data('first_name');

    doFormPost(baseUrl + "/family/searchPeople?type=addfather",
            '{ "type":"addfather","fid":"' + id + '","gid":"' + gid + '","name_parent":"' + first_name + '"}');
});

$('.addmother').click(function () {

    var $this = $(this);
    var id = $this.data('id');
    var gid = $this.data('gid');
    var first_name = $this.data('first_name');
    doFormPost(baseUrl + "/family/searchPeople?type=addmother",
            '{ "type":"addmother","fid":"' + id + '","gid":"' + gid + '","name_parent":"' + first_name + '"}');

});
$('.addsister').click(function () {
    var $this = $(this);
    var id = $this.data('id');
    var gid = $this.data('gid');
    var first_name = $this.data('first_name');

    doFormPost(baseUrl + "/family/searchPeople?type=addsister",
            '{ "type":"addsister","fid":"' + id + '","gid":"' + gid + '","name_parent":"' + first_name + '"}');
});

$('.addbrother').click(function () {
    var $this = $(this);
    var id = $this.data('id');
    var gid = $this.data('gid');
    var first_name = $this.data('first_name');

    doFormPost(baseUrl + "/family/searchPeople?type=addbrother",
            '{ "type":"addbrother","fid":"' + id + '","gid":"' + gid + '","name_parent":"' + first_name + '"}');
});
$('.addchild').click(function () {

    var $this = $(this);
    var id = $this.data('id');
    var first_name = $this.data('first_name');
    var gid = $this.data('gid');
doFormPost(baseUrl + "/family/searchPeople?type=addchilld",
            '{ "type":"addchilld","fid":"' + id + '","gid":"' + gid + '","name_parent":"' + first_name + '"}');
            
   


}); 

$('.editeducation').click(function () {
    var $this = $(this);
    var id = $this.data('id');
    var gid = $this.data('gid');

    doFormPost(baseUrl + "/family/addEducation?type=addEducation&id=" + id + "&gid=" + gid,
            '{ "type":"addEducation","fid":"' + id + '","gid":"' + gid + '"}');

});


function createThumbPreview() 
{
    var t = '1:1';
    var newW = imageAreaselectDefault;
    
    if( hcurrentwidth > newW) {
        newW = imageAreaselectDefault;
    } else {
        newW = hcurrentwidth;
    }
    
    var newH = imageAreaselectDefault;
    if( hcurrentheight > newH) {
        newH = imageAreaselectDefault;
    } else {
        newH = hcurrentheight;
    }
    
    if( newH > newW) {
        newH = newW;
    }
    if( newW > newH) {
        newW = newH;
    }
    
   
    $('#thumbnail').imgAreaSelect({ 
        fadeSpeed: 400,
        parent:$('#parent'),
        x1: 0, 
        y1: 0, 
        x2: newW - 10, 
        y2: newH - 10,
        minWidth: newW, 
        minHeight: newH,
        instance: true,
        show:true,
        handles: true,
        aspectRatio : t,
        onSelectChange: preview,
        persistent:true
    }); 
    
    $('.publishFansPopup').css('height',newH+'px');
}
var dialog;
$(document).ready(function () {
    
    
    
    
    $( ".combobox" ).combobox({width: '180px',select: function( event, ui ) {
      $('.owner').val(ui.item.value);
      }});
    dialog = $("#dialog-form").dialog({
        autoOpen: false,
        height: 'auto',
        width: 'auto',
        modal: false,
        buttons: {
        "Submit": transferUser,
        Cancel: function () {
                dialog.dialog("close");
            }
        },
        close: function () {
        }
    });

});

function transferUser()
{
   
     $.ajax({
        url: baseUrl + '/family/transfer',
        dataType: 'json',
        data: {id: $(this).data('id'),ownergroupid:$('.owner').val()},
        type: "POST",
        success: function (response) {
            var displayMsg = response.message;
            showJsSuccessMessage(displayMsg);
            setTimeout(function () {
                $('.jssuccessMessage').hide('slow');
                window.location.href = baseUrl + '/family/details/' + groupid;
                
            }, 2500);
        }
    });
    
}

$(".transfer-family").on("click", function () {
    var $this = $(this);
     var id = $this.data('id');
    
    var gid = $this.data('gid');
    doFormPost(baseUrl + "/family/transfer?type=transfer",
            '{ "type":"transfer","fid":"' + id + '","gid":"' + gid + '"}');
       
    //$("#dialog-form").data('id',$(this).data('id')).dialog("open");
   // return false;
});

$('.deletemember').click(function(){
 var result = confirm("Want to delete?");
    if (result === true) {
     var $this = $(this);
    var id = $this.data('id');
    var gid = $this.data('gid');
     $.ajax({
        url: baseUrl + '/family/deleteMember',
        dataType: 'json',
        data: {id: id,groupid:gid},
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
} else {
return;
}
});

$('.make_hof').click(function()
{   
    var peopleData = {};
    var $this = $(this);
    var id = $this.data('id');
    var gid = $this.data('gid');
    peopleData['first_name'] = $(this).data('first_name');
    peopleData['last_name'] = $(this).data('last_name');
    peopleData['phone_number'] = $(this).data('mobile_number');
    peopleData['village'] =  $(this).data('village');
    peopleData['email'] = $(this).data('email');
    
    //$('.insert').attr('disabled',true);  
    
    $.ajax({
        url: baseUrl + '/family/insertUser',
        dataType: 'json',
        data: {peopleid: id, type: 'addnew', gid: gid,data: peopleData},
        type: "POST",
        success: function (response) {
            var displayMsg = response.message;
            showJsSuccessMessage(displayMsg);
            setTimeout(function () {
                $('.jssuccessMessage').hide('slow');
                window.location = baseUrl + '/family/details/'+ response.group_id;
            }, 2500);
        },
        error: function()
        {
          $('.insert').attr('disabled',false);  
        }
    });
});
