$(document).ready(function() {
    var perPage = 9;
    var numItems = parseInt($('#recTot').attr('data'));
    
    var start = 0;
    goTo(start, perPage);
});

function imageExists(image_url){

    var http = new XMLHttpRequest();

    http.open('HEAD', image_url, false);
    http.send();

    return http.status != 404;

}


function goTo(page, perPage){
    var startAt = page * perPage,
    endOn = startAt + perPage;
    
    var data = [];
    data['start'] = startAt;
    data['length'] = endOn;
   
    $.post(baseUrl + "/article/gridArticles",
    {
      start:startAt,
      length:endOn
    },
    function(data,status){
      res = JSON.parse(data);
      totRec = res.iTotalRecords;     
       
     
      $('#content_view').html('');
      data = res.aaData;
      $.each(data, function(idx, obj) {
          imgSrc = "http://placehold.it/150x150";
      	  if (obj[5]) {
      	  	imgSrc = 'http://admin.kvomahajan.com/files/article/thumb/'+obj[5];
      	 
      	  	if (!imageExists(imgSrc)) {
                    imgSrc = "http://placehold.it/150x150";
                }
      	  }
      	  con = '<div class="row">';
          con += '  <div class="well">';
          con += '      <div class="media">';
          con += '          <a class="pull-left" href="'+baseUrl+'/article/detail?id='+obj[0]+'"><img class="media-object" src="'+imgSrc+'" alt="'+obj[1]+'"></a>';
          con += '          <div class="media-body">';
	  con += '		<h4 class="media-heading">'+obj[1]+'</h4>';
	  con += '		<p class="text-right">By '+obj[2]+'</p>';
	  con += '		<p>'+obj[4]+'</p>';
	  con += '		<ul class="list-inline list-unstyled">';
	  con += '                  <li>';
          con += '                      <span><i class="fa fa-2x fa-facebook-square"></i></span>';
          con += '                      <span><i class="fa fa-2x fa-twitter-square"></i></span>';
          con += '                      <span><i class="fa fa-2x fa-google-plus-square"></i></span>';
	  con += '                  </li>';
	  con += '		</ul>';
	  con += '          </div>';
          con += '      </div">';
          con += '  </div">';
          con += '</div">';
          
          $('#content_view').append(con);
      });
      
      if (totRec == '0') {
          $('#content_view').html('No articles available.');     
          $('#page_pagination').html('');
      }  else {
      
       $('#page_pagination').pagination(totRec,perPage,page,{callback:function(page,component){
            goTo(page, perPage);
        }});
      }
    }); 
}