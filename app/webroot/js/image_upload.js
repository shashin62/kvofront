var currentwidth = parseInt($('#hcurrentwidth').val());
var currentheight = parseInt($('#hcurrentheight').val());
//var thumb_height = parseInt($('#hthumb_height').val());
//var thumb_width = parseInt($('#hthumb_width').val());
var userImagePath = parseInt($('#huserImagePath').val());
//var userThumbImagePath =parseInt($('#huserThumbImagePath').val());  

function createThumbPreview() {
    
    var t = '1:1';
    var newW = 346;
   
   
   
    if( (currentheight <= 600 && currentwidth <= 700) ||   (currentheight <= 800 && currentwidth <= 500)) {
        
        $('.fansPreview').css('width',currentwidth + 230 + 'px');
        $('.uploadImage').css('width',currentwidth +'px');
    } else {
        $('.uploadImage').css('width','720px');
         $('.fansPreview').css('width','950px');
    }
    if( currentwidth > newW) {
        newW = 346;
    } else {
        newW = currentwidth;
    }
    
    var newH = 346;
    if( currentheight > newH) {
        newH = 346;
    } else {
        newH = currentheight;
    }
    
    if( newH > newW) {
        newH = newW;
    }
    if( newW > newH) {
        newW = newH;
    }
    
    //
    
    var pt = parseInt($('#logo_selection_area').val());
    
    
   
    $('#thumbnail').imgAreaSelect({ 
        fadeSpeed: 400,
        parent:$('#parent'),
       
        show:true,
        x1: 0, 
        y1: 0, 
        x2: newW - 10, 
        y2: newH - 10,
        minWidth: newW, 
        minHeight: newH,
        handles: true,
        aspectRatio : t,
        instance: true,
        resizable:true,
        onSelectChange: preview,
        persistent:true
    }); 
}    
    function preview(img, selection) { 
    
    var scaleX = 120 / selection.width; 
    var scaleY = 120 / selection.height; 
    
     $('#thumbPreview').css('width' ,Math.round(scaleX * currentwidth) + 'px');
    $('#thumbPreview').css('height' ,Math.round(scaleY * currentheight) + 'px');
    $('#thumbPreview').css('marginLeft' ,'-'+Math.round(scaleX * selection.x1) + 'px');
    $('#thumbPreview').css('marginTop' ,'-'+Math.round(scaleY * selection.y1) + 'px');
    
   
    $('#x1').val(selection.x1);
	$('#y1').val(selection.y1);
	$('#x2').val(selection.x2);
	$('#y2').val(selection.y2);
	$('#w').val(selection.width);
	$('#h').val(selection.height);
}


 $('.cancel_upload').click(function(){
     $('div[class^=imgareaselect-]').hide();
     $(".postwrapper, #overlay").fadeOut(); 
  });
  $('.prviewClose').click(function(){
     $('div[class^=imgareaselect-]').hide();
     document.body.style.overflow = 'auto';
  });