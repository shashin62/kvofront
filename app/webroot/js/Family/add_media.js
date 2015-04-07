$('.cancel_upload').click(function(){
     $('div[class^=imgareaselect-]').hide();
     $(".postwrapper, #overlay").fadeOut(); 
     $('.imgareaselect-selection').hide();
     
      document.body.style.overflow = "visible";
  });
  
  $('.prviewClose').click(function(){
   
       // 
   
     $('div[class^=imgareaselect-]').hide();
     $('.imgareaselect-selection').hide();
     document.body.style.overflow = "visible";
     $('.fanPostImageOnly').css('border','1px solid #999');
  });

$('#save_thumb').click(function(){
    
    var h = $('#h').val();
    var w = $('#w').val();
    var y2 = $('#y2').val();
    var x2 = $('#x2').val();
    var y1 = $('#y1').val();
    var x1 = $('#x1').val();
  
    var filePath  = $('#filePath').val();
    
    $.ajax({
            url:baseUrl+'/image/resizeImage',
            dataType: 'json',
             beforeSend: function(){
                $(".loading_overlay").show();
                 $('#overlay').show();
            },
            complete: function(){                
                $(".loading_overlay").hide();
                 $('#overlay').hide(); 
            },
            type:"POST",
                data:{
                    h:h,
                    w:w,
                    y2:y2,
                    x2:x2,
                    y1:y1,
                    x1:x1,
                    filePath:filePath,
                    thumb_width:$('#hthumb_width').val(),
                    userImagePath :$('#huserImagePath').val(),
                    userThumbImagePath :$('#huserThumbImagePath').val(),
                    type:"peopleLogo",
                    id : pid
                },
           
            success:function(response){
               if( response.status == 1) {
                     
                setTimeout(function () {
                    $('.jssuccessMessage').hide('slow');
                    
                    window.location.href= baseUrl + '/family/details/' +  gid;
                }, 2000);
                $('div[class^=imgareaselect-]').hide();
                $(".postwrapper, #overlay").fadeOut(); 
                $('.fanPostImageOnly').css('border','none');
                 
               }
            } ,
            error: function(response) {}
    });
    document.body.style.overflow = "visible";
    
});