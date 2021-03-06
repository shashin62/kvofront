/*

	This Family Echo file is Copyright (c) Familiality Ltd.



	This file may be distributed only in whole and unmodified, as part of a

	family downloaded from Family Echo. You may make this file available on the

	World Wide Web without modification, only if used to display a family

	downloaded from Family Echo. You may make copies of this file for personal

	archiving purposes, only as part of a family downloaded from Family Echo.



	This file may not be distributed or copied for any other purpose. You are

	not permitted to modify, merge, publish, sublicense, rent, sell, lease,

	loan, decompile, reverse engineer or create derivative works from this file.



	This copyright and license notice must be kept in all copies of this file.

*/



var ios=navigator.userAgent.match(/(iPod|iPhone|iPad)/)&&navigator.userAgent.match(/AppleWebKit/);

function TND(){

    return {

	l:0,

	r:0,

	w:0,

	t:0,

	b:0,

	h:0,

	e:{},

	n:[]

    };

}

function TAE(d,i,p,x,y,k){

    var di=d.e[i];

    if(di){

	i+=Math.random(0,999999);

    }

    d.e[i]={

	p:p,

	x:x,

	y:y,

	k:k,

	d:di

    };

    d.l=Math.min(d.l,x);

    d.r=Math.max(d.r,1+x);

    d.w=d.r-d.l;

    d.t=Math.min(d.t,y);

    d.b=Math.max(d.b,1+y);

    d.h=d.b-d.t;

}

function TAL(d,x1,y1,x2,y2,k){

    d.n[d.n.length]={

	x1:x1,

	y1:y1,

	x2:x2,

	y2:y2,

	k:k

    };

}

function TAD(od,d,dx,dy){

    for(var j=0;j<d.n.length;j++){

	var n=d.n[j];

	TAL(od,n.x1+dx,n.y1+dy,n.x2+dx,n.y2+dy,n.k);

    }

    for(var i in d.e){

	var e=d.e[i];

	TAE(od,e.p.i,e.p,e.x+dx,e.y+dy,e.k);

    }

}

function TDS(zf,y,mn,sp){

    return {

	Tew:parseInt(((y||sp||mn)?100:80)*zf),

	Teh:parseInt((40+(y?40:0)+(sp?100:0))*zf),

	Tph:parseInt(100*zf),

	Tdh:parseInt(40*zf),

	Tmh:parseInt(40*zf),

	Ths:parseInt(20*zf),

	Tvs:parseInt((y?40:60)*zf),

	Tfs:parseInt(12*zf),

	Tds:parseInt(10*zf)

	};

}

function TRD(d,y,bn,mn,sp,o,oi,wp,pr,zf,_24){

    var _25=(wp&&!ios)?19200:0;

    var _26=(wp&&!ios)?12000:0;

    var sz=TDS(zf,y,mn,sp);

    var tw=(sz.Tew+sz.Ths)*d.w-sz.Ths;

    var th=(sz.Teh+sz.Tvs)*d.h-sz.Tvs;
    

    if(!wp){

	ox=sz.Tew/2-d.l*(sz.Tew+sz.Ths);

	oy=sz.Teh/2-d.t*(sz.Teh+sz.Tvs);

    }else{

	if(ios){

	    if(!(o.ios_width&&o.ios_height)){

		o.ios_width=parent.GE("treeframe").offsetWidth;

		o.ios_height=parent.GE("treeframe").offsetHeight;

	    }

	    ox=o.ios_width/2;

	    oy=o.ios_height/2;

	    o.style.left="0px";

	    o.style.top="0px";

	}else{

	    if(oi&&o.ps[oi]&&d.e[oi] && oi != 'START'){

		ox=o.ps[oi].x-d.e[oi].x*(sz.Tew+sz.Ths);

		oy=o.ps[oi].y-d.e[oi].y*(sz.Teh+sz.Tvs);

	    }else{
                if (d.l <= 0) {
                    d.l = -5;
                    if (d.t === -1) {
                        d.t = -3;
                    }
                }


		ox=_25-d.l*(sz.Tew+sz.Ths);

		oy=_26-d.t*(sz.Teh+sz.Tvs);

	    }

	}

    }

    o.innerHTML="";

    o.ps={};

    o.es={

	l:(ox+(d.l-0.5)*(sz.Tew+sz.Ths)),

	t:(oy+(d.t-0.5)*(sz.Teh+sz.Tvs)),

	r:(ox+(d.r-0.5)*(sz.Tew+sz.Ths)),

	b:(oy+(d.b-0.5)*(sz.Teh+sz.Tvs))

	};

    var s=o.style;

    s.width=(tw+_25*2)+"px";

    s.height=(th+_26*2)+"px";

    for(var j=0;j<d.n.length;j++){

	var n=d.n[j];

	var l=Math.min(n.x1,n.x2);

	var r=Math.max(n.x1,n.x2);

	var t=Math.min(n.y1,n.y2);

	var b=Math.max(n.y1,n.y2);

	if(pr){

	    var k=n.k?2:1;

	    var ko=k;

	    var v=document.createElement("img");

	    v.src=(n.k===null)?((r==l)?"grayvcheck.gif":"grayhcheck.gif"):"graypixel.gif";

	    v.style.position="absolute";

	}else{

	    var k=n.k?4:((n.k===null)?0:2);

	    var ko=n.k?4:2;

	    var v=document.createElement("div");

	    v.className=(n.k===null)?"ddotted":"dline";

	}

	var s=v.style;

	s.width=((r==l)?k:(r-l)*(sz.Tew+sz.Ths)+k)+"px";

	s.height=((b==t)?k:(b-t)*(sz.Teh+sz.Tvs)+k)+"px";

	s.left=ox+(l*(sz.Tew+sz.Ths)-ko/2)+"px";

	s.top=oy+(t*(sz.Teh+sz.Tvs)-ko/2)+"px";

	o.appendChild(v);

    }
    for(var i in d.e){

	var e=d.e[i];

	var rs="";

	var sn=bn?(e.p.q||e.p.l):(e.p.l||e.p.q);

	var fn=e.p.hp?(e.p.p+(sn?(" "+sn):"")):e.p.h;

	var cc=((e.p.z=="1")&&!pr)?"dcelld":"dcella";

	var sh=sz.Tmh;
        
        var pPhoto = false;

	if(sp&&e.p.r){

	    var ey=e.p.r.split(" ");

	    var uf=(parent&&parent.EIU)||(opener&&opener.top&&opener.top.EIU);

	    if(uf){

		var u=uf(ey[0]);

		var ew=sz.Tew-4;

		var eh=sz.Tew-4;

		if(ey[1]&&ey[2]){

		    if(parseInt(ey[1])>parseInt(ey[2])){

			eh=Math.floor(ew*ey[2]/ey[1]);

		    }else{

			ew=Math.floor(eh*ey[1]/ey[2]);

		    }

		}
               
               
                if( d.e[i].p.r != '') {
                     
                     //u = "../../people_images/"+d.e[i].p.r;
                     u = d.e[i].p.r;
                     pPhoto = true;
                    
                } else {
                     u = "ap/images/image-1.jpg";
                }
		rs+="<TR><TD CLASS=\""+cc+"\"><IMG SRC=\""+u+"\" WIDTH=\""+ew+"\" HEIGHT=\""+eh+"\" TITLE=\""+EH(fn)+"\"></TD></TR>";

		sh+=sz.Tph;

	    }

	}

	if(y){

	    var ey=TGL(y,e.p);

	    if(ey&&ey.length){

		rs+="<TR><TD CLASS=\""+cc+"\" STYLE=\"font-size:"+sz.Tds+"px;\" TITLE=\""+EH(ey.replace(/\n/g,", "))+"\">"+EL(ey)+"</TD></TR>";

		sh+=sz.Tdh;

	    }

	}

	var sx=ox+(e.x)*(sz.Tew+sz.Ths);

	var sy=oy+(e.y)*(sz.Teh+sz.Tvs);

	if(pr){

	    v=document.createElement("img");

	    v.src=((e.p.g=="f")?"female":((e.p.g=="m")?"male":"neuter"))+"pixel.gif";

	    var s=v.style;

	    s.position="absolute";

	    s.width=sz.Tew+"px";

	    s.height=sh+"px";

	    s.left=(sx-(sz.Tew/2))+"px";

	    s.top=(sy-(sh/2))+"px";

	    o.appendChild(v);

	}else{

	    if(e.k){

		TRB(o,sx-(sz.Tew/2),sy-(sh/2),sz.Tew,sh,3,"000",_24);

	    }

	    TRB(o,sx-(sz.Tew/2),sy-(sh/2),sz.Tew,sh,1,(e.p.g=="f")?"FFD6EE":((e.p.g=="m")?"D6DDFF":"FFFFFF"),null);

	}

	var v=document.createElement("div");

	v.className="di";

	var s=v.style;

	s.width=sz.Tew+"px";

	s.height=sh+"px";

	s.left=(sx-(sz.Tew/2))+"px";

	s.top=(sy-(sh/2))+"px";

	if(wp){

	    //v.onmousedown=TCT;
            v.onmousedown = function(e) {
                window.parent.resetJSONValue(this.pid);
                e.preventDefault();
            };
            v.onclick = CLCK;

	    v.id=i;

	    v.pid=e.p.i;

	    o.ps[i]={

		x:sx,

		y:sy

	    };

	}

	var tn=e.p.hp?(mn?fn:(e.p.h+(sn?(" "+sn):""))):e.p.h;
 if( e.p.g == "m") {
                      u = "ap/images/user_male.png";
                    } else {
                        u = "ap/images/user_female.png";
                    }
        if (!pPhoto) {
            gPic = 'inline';
        } else {
            gPic = 'none';
        }
	v.innerHTML="<TABLE WIDTH=\"100%\" HEIGHT=\"100%\" STYLE=\"table-layout:fixed;\">"+"<TR><TD CLASS=\""+cc+"\" STYLE=\"font-size:"+(e.d?sz.Tds:sz.Tfs)+"px;\""+" TITLE=\""+e.p.p+" "+e.p.l+"\"><img id=\"personimage\" src=\""+ u + "\" class=\"simage\" style=\"display: "+gPic+"; margin-right: 6px; width: 22px; height: 22px;\" onclick=\"SIC(); return false;\" >"+(e.d?"Duplicate: ":"")+EH(fn)+"</TD></TR>"+rs+"</TABLE>";

	o.appendChild(v);

    }

}

function CLCK()
{
   
    return;
    var peopleid = this.id;
    $("#popup").dialog({
        title: "Details",
        width: 800,
        modal: true,
        resizable: false,
    position: [0,58],
    create: function (event) { $(event.target).parent().css('position', 'fixed');},
        open: function () {
 
            $.ajax({
                url: 'http://website.kvomahajan.com/family/getPeopleData?id=' + peopleid,
                dataType: 'json',
                type: "GET",
                success: function (response) {
                    
                    $('#popup').empty();
                    var $html = ' <h4 class="heading">Personal Details</h4>';
                    $html += '<div class="control-group">';
                    $html += '<div class="controls form-inline">';
                    $html += '<label for="inputKey">First Name:</label><span>' + response.People.first_name + '</span>&nbsp;&nbsp;';
                    $html += ' <label for="inputKey">Last Name:</label><span>' + response.People.last_name + '</span>&nbsp;&nbsp;';
                    $html += '<label for="inputKey">Village:</label><span>' + response.People.village + '</span>&nbsp;&nbsp;';
                    $html += '</div>';
                    $html += '</div>';
                     $html += '<div class="control-group">';
                    $html += '<div class="controls form-inline">';
                    $html += '<label for="inputKey">Mobile:</label><span>' + (response.People.mobile_number ? response.People.mobile_number : '-') + '</span>&nbsp;&nbsp;';
                    $html += '<label for="inputKey">DOB:</label><span>' + (response.People.date_of_birth ? response.People.date_of_birth : '-') + '</span>&nbsp;&nbsp;';
                    $html += '<label for="inputKey">Martial Status:</label><span>' + response.People.martial_status + '</span>&nbsp;&nbsp;';
                    
                    $html += '</div>';
                    $html += '</div>';
                    $html += ' <h4 class="heading">Family Details</h4>';
                     $html += '<div class="control-group">';
                    $html += '<div class="controls form-inline">';
                    $html += '<label for="inputKey">Spouse:</label><span>' + response.People.partner_name + '</span>&nbsp;&nbsp;';
                    $html += '<label for="inputKey">Father:</label><span>' + (response.parent1.father ? response.parent1.father : '-') + '</span>&nbsp;&nbsp;';
                    $html += '<label for="inputKey">Mother:</label><span>' + (response.parent2.mother ? response.parent2.mother : '-') + '</span>&nbsp;&nbsp;';
                     $html += '</div>';
                    $html += '</div>';
                     $html += ' <h4 class="heading">Education Details</h4>';
                     $html += '<div class="control-group">';
                    $html += '<div class="controls form-inline">';
                    $html += '<label for="inputKey">Education</label><span>' + (response.People.education_1 ? response.People.education_1 : '-') + '</span></div>';
                    $html += '</div>';
                    $html += '</div>';
                     $html += ' <h4 class="heading">Busniess Details</h4>';
                     $html += '<div class="control-group">';
                    $html += '<div class="controls form-inline">';
                    $html += '<label for="inputKey">Busniess Type:</label><span>' + (response.People.business_name ? response.People.business_name : '-') + '</span>&nbsp;&nbsp;';
                    $html += '<label for="inputKey">Busniess Specialty:</label><span>' + (response.People.specialty_business_service ? response.People.specialty_business_service : '-') + '</span>&nbsp;&nbsp;';
                    $html += '<label for="inputKey">Busniess Nature:</label><span>' + (response.People.nature_of_business ? response.People.nature_of_business : '-') + '</span>&nbsp;&nbsp;';
                    $html += '<label for="inputKey">Busniess Name:</label><span>' + (response.People.name_of_business ? response.People.name_of_business : '-') + '</span>&nbsp;&nbsp;';
                     $html += '</div>';
                    $html += '</div>';
                    $('#popup').html($html);
                }
            });
            
        },
        close: function (e) {
            $(this).empty();
            $(this).dialog('destroy');
        }
        
    });
    
    return false;

}
function TGL(y,p){

    var ey="";

    if(y=="tku"){

	ey=p.t?("\n"+p.t+" (h)"):"";

	ey+=p.k?("\n"+p.k+" (w)"):"";

	ey+=p.u?("\n"+p.u+" (m)"):"";

	if(ey){

	    ey=ey.substring(1);

	}

    }else{

	if(y=="bds"){

	    var bs=FDT(p.b);

	    var ds=FDT(p.d);

	    ey=(bs?("Born "+bs):"")+((bs&&ds)?"\n":"")+(ds?("Died "+ds):"");

	}else{

	    if(y=="bd"){

		var bs=FPD(p.b||"").y;

		var ds=FPD(p.d||"").y;

		ey=(bs&&ds)?(bs+"-"+ds):(bs?("Born "+bs):(ds?("Died "+ds):""));

	    }else{

		if(y=="bv"){

		    var bs=FDT(p.b);

		    ey=((bs||p.v)?"Born ":"")+(bs||"")+((bs&&p.v)?", ":"")+(p.v||"");

		}else{

		    if(y=="dy"){

			var ds=FDT(p.d);

			ey=((ds||p.y)?"Died ":"")+(ds||"")+((ds&&p.y)?", ":"")+(p.y||"");

		    }else{

			if(y=="e"){

			    ey=p.e?p.e.replace(/@/g,"@ "):"";

			}else{

			    if(y!="r"){

				ey=p[y];

			    }

			}

		    }

		}

	    }

	}

    }

    return ey;

}

function TCD(o,i,t){

    if(i&&o.ps[i]){

	var dw,dh;

	if(self.innerHeight){

	    dw=self.innerWidth;

	    dh=self.innerHeight;

	}else{

	    if(document.documentElement&&document.documentElement.clientHeight){

		dw=document.documentElement.clientWidth;

		dh=document.documentElement.clientHeight;

	    }else{

		if(document.body){

		    dw=document.body.clientWidth;

		    dh=document.body.clientHeight;

		}

	    }

	}

	if((dw<64)||(dw>4096)){

	    dw=self.outerWidth;

	}

	if((dh<64)||(dh>4096)){

	    dh=self.outerHeight;

	}

	var sx=o.ps[i].x-dw/2;

	var sy=o.ps[i].y-dh/2;

	if(o.es){

	    var as={

		l:sx+64,

		t:sy+32,

		r:sx+dw-32,

		b:sy+dh-64

		};

	    sx+=0.9*(Math.min(0,Math.max(o.es.l-as.l,o.es.r-as.r))+Math.max(0,Math.min(o.es.l-as.l,o.es.r-as.r)));

	    sy+=0.9*(Math.min(0,Math.max(o.es.t-as.t,o.es.b-as.b))+Math.max(0,Math.min(o.es.t-as.t,o.es.b-as.b)));

	}

	var scs=DT();

	TSS(sx,sy,scs,scs+t,"_sel");

    }

}

function TRB(o,l,t,w,h,k,b,_58){

    v=document.createElement("div");

    var s=v.style;

    if(_58){

	s.visibility="hidden";

	v.id=_58;

    }

    s.position="absolute";

    s.width=(w+k*2)+"px";

    s.left=(l-k)+"px";

    s.top=(t-k)+"px";

    var e="background:#"+b+";"+((k==1)?"":("border-width:0 "+k+"px;"));

    var e2=(k>1)?"background:#000;":"";

    var e3=(k>2)?"background:#000;":"";

    var e4=(k>2)?"border-width:0 "+(k+1)+"px;":"";

    v.innerHTML="<b class=\"db\"><b class=\"db1\"></b><b class=\"db2\" style=\""+e+e2+"\"></b><b class=\"db3\" style=\""+e+e3+"\"></b><b class=\"db4\" style=\""+e+e4+"\"></b><b class=\"db4\" style=\""+e+"\"></b></b><div class=\"dc\" style=\"height:"+(h+k*2-10)+"px;"+e+"\"></div>"+"<b class=\"db\"><b class=\"db4\" style=\""+e+"\"></b><b class=\"db4\" style=\""+e+e4+"\"></b><b class=\"db3\" style=\""+e+e3+"\"></b><b class=\"db2\" style=\""+e+e2+"\"></b><b class=\"db1\"></b></b>";

    o.appendChild(v);

}

var Tpd=false;

var Tdx,Tdy,moveobject;

function TGS(){

    if(self.pageYOffset){

	scrolltop=self.pageYOffset;

	scrollleft=self.pageXOffset;

    }else{

	if(document.documentElement&&document.documentElement.scrollTop){

	    scrolltop=document.documentElement.scrollTop;

	    scrollleft=document.documentElement.scrollLeft;

	}else{

	    if(document.body){

		scrolltop=document.body.scrollTop;

		scrollleft=document.body.scrollLeft;

	    }

	}

    }

    return {

	top:scrolltop,

	left:scrollleft

    };

}

function TIS(o){

    moveobject=o;

    o.onmousedown=function(_5f){

	_5f=_5f?_5f:window.event;

	Tpd=true;

	scrollpos=TGS();

	Tdx=scrollpos.left+_5f.screenX;

	Tdy=scrollpos.top+_5f.screenY;

    };

    o.onmouseup=function(_60){

	Tpd=false;

    };

    document.onmousemove=function(_61){

	_61=_61?_61:window.event;

	if(Tpd){

	    TSS(Tdx-_61.screenX,Tdy-_61.screenY,0,0,null);

	}

    };

    o.ontouchstart=function(_62){

	if((_62.target==moveobject)&&(_62.touches.length==1)){

	    Tpd=true;

	    Tdx=moveobject.offsetLeft-_62.touches[0].screenX;

	    Tdy=moveobject.offsetTop-_62.touches[0].screenY;

	    _62.preventDefault();

	}

    };

    o.ontouchend=function(_63){

	if(Tpd){

	    Tpd=false;

	    _63.preventDefault();

	}

    };

    document.ontouchmove=function(_64){

	if(Tpd){

	    moveobject.style.left=(Tdx+_64.touches[0].screenX)+"px";

	    moveobject.style.top=(Tdy+_64.touches[0].screenY)+"px";

	    _64.preventDefault();

	}

    };

}

var Tst=null,Tsf,Tsd,Tss,Tse,Tsv;

function TSS(x,y,scs,scf,scv){

    if(Tst){

	clearTimeout(Tst);

	Tst=null;

    }

    Tsf=TGS();

    Tsd={

	top:y,

	left:x

    };

    Tss=scs;

    Tse=scf;

    Tsv=scv;

    if(DT()>=scf){

	TST();

    }else{

	Tst=setTimeout("TST()",10);

    }

}

function TST(){

    var n=DT();

    if(n>=Tse){

	direct_scroll_to(Tsd.left,Tsd.top);

	if(Tsv&&GE(Tsv)){

	    SI(Tsv,true);

	}

    }else{

	var p=(n-Tss)/(Tse-Tss);

	p=1-Math.pow(0.5,p/0.2);

	direct_scroll_to(Tsf.left+p*(Tsd.left-Tsf.left),Tsf.top+p*(Tsd.top-Tsf.top));

	Tst=setTimeout("TST()",10);

    }

}

function direct_scroll_to(x,y){

    if(!ios){

	self.scrollTo(x,y);

    }

}

function TCT(){
    
    parent.ESP(this.pid,true);

}

function TFE(o,i){

    return (o.ps&&i)?o.ps[i]:null;

}

function TRT(f,i,m,y,bn,mn,sp,ch,ph,co,pi,zf,s){

    var o=GE("treebg");

    var _7e=null;

    if(TFE(o,i)){

	var oi=i;

	var sd=0;

	if(i!=pi){

	    _7e="_sel";

	    if(GE(_7e)){

		SI(_7e,false);

	    }

	}

    }else{

	var oi=TFE(o,pi)?pi:null;

	var sd=oi?250:0;

    }

    TRD(BFT(f,i,m,ch,ph,co),y,bn,mn,sp,o,oi,true,false,zf,_7e);

    setTimeout("TCD(GE('treebg'), '"+i+"', "+(s?250:0)+")",sd);

}
