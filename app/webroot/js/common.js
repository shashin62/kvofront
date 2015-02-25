function doFormPost(url , data) {    
    var data = $.parseJSON(data);   
    var number = Math.ceil(Math.random() * 10) + 3;    
    var form = '<form method="POST" action ='+ url+ ' id="form_'+ number +'">';   
    for( var key in data) {       
        form += '<input type ="hidden" name="'+ key +'" value="'+ data[key]+'">';
    }
    form += '</form>';    
    $('body').append(form);
    $('#form_'+number).submit();
}

function showJsSuccessMessage(message) {
    centerMessage('customFlash');
    $('.jssuccessMessage').show().html(message);
    
}

function centerMessage(holder){
    var msgWidth, bodyWidth, successMsg, finalVal;
	bodyWidth = $('body').width();
	successMsg = $('#'+holder);
	msgWidth = successMsg.width();
	
	var finalVal = ((bodyWidth - msgWidth)/2);
	
	successMsg.css({left: finalVal+'px'}).show();
}
var filterFlag;
function displayErrors(ename,etype,error, callType, marginLeft)
{   
    marginLeft = typeof(marginLeft) != 'undefined' ? marginLeft : "";


    //alert(marginLeft)
    if($('#'+ename+'_err').length > 0) {
        if(callType == 'server') {
            $('#'+ename+'_err').attr('style',"display:;");
            $('#'+ename+'_err').html(error);
        } else {
            $('#'+ename+'_err').html(error.text());
        }
       
        var eid = ename+'_err';
        //$("#"+eid).css('margin-left', marginLeft);

    } else {

        if(callType == "server") {
            errorMsg = '<span htmlfor="'+ename+'" id="'+ename+'_err" generated="true" class="error" style="display:;">'+error+'</span>';
        } else {
            error.attr("id",ename+'_err');
            errorMsg = error;
        }

        if(etype == 'select-one') {
            $('#'+ename).parent().append(errorMsg);
        } else if(etype == "radio") {
            if(callType == 'server') {               
                $('#'+ename).parent().parent().append(errorMsg);
            } else {
                $('#'+ename).parent().parent().append(errorMsg);
            }
        } else if(etype == 'select-multiple'){
            $('#'+ename).parent().append(errorMsg);
        } else if(etype == "postdate") {
            if(callType == 'server') {
                $('#'+ename).parent().parent().append(errorMsg);
            } else {
                $('#'+ename).parent().parent().append(errorMsg);
            }
        } else {
            $('#'+ename).parent().append(errorMsg);
        }
        
        // overwrite the margin-left
        var eid = ename+'_err';
        //if(marginLeft != "") {
            //$("#"+eid).css('margin-left', marginLeft);
        //}
    }
}
function format(d) {
    
    var maiden_village = d['10'] ? d['10'] : '-';
    var maiden_surname = d['11'] ? d['11'] : '-';
    var grand_father = d['15'] ? d['15'] : '-';
    var grand_mother = d['16'] ? d['16'] : '-';
    var spouse = d['9'] != null ? d['9'] : '-';
    return '<table cellpadding="5" cellspacing="0" border="0" style="">' +
            '<tr>' +
            '<td>&nbsp<b>Father</b>:' +
            '' + d['13'] + '</td>&nbsp;' +
            '<td>&nbsp<b>Mother</b>: ' +
            '' + d['14'] + '</td>&nbsp;' +
            '<td>&nbsp<b>Village</b>: ' +
            '' + d['4'] + '</td>&nbsp;' +
            '<td>&nbsp<b>Email</b>: ' +
            '' + d['12'] + '</td>&nbsp;' +
            '<td>&nbsp<b>Spouse</b>: ' +
            '' + spouse + '</td></tr><tr>&nbsp;' +
            '<td>&nbsp<b>Maiden Village</b>: ' +
            '' + maiden_village + '</td>&nbsp;' +
            '<td>&nbsp<b>Maiden Surname</b>: ' +
            '' + maiden_surname + '</td>&nbsp;' +
            '<td>&nbsp<b>Grand Father</b>: ' +
            '' + grand_father + '</td>&nbsp;' +
            '<td>&nbsp<b>Grand Father(Mother)</b>: ' +
            '' + grand_mother + '</td>&nbsp;' +
            '</tr>' +
            '</table>';
}


$(document).ready(function(){
      $(".prviewClose, .prviewCloseText").click( function(){
            $(".postwrapper, #overlay").fadeOut();
            $("#postview").html("");
        }); 
    $("body").append("<div id='overlay'></div>");
        $("body").append("<div id='postview'></div>"); 
    
});
