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

function GE(e){
return document.getElementById(e);
}
function SV(e,v){
GE(e).value=v?v:"";
}
function GV(e){
return GE(e).value;
}
function SO(e,v){
var s=GE(e);
var v=v?v:"";
for(var j=0;j<s.options.length;j++){
if(s.options[j].value==v){
s.selectedIndex=j;
}
}
}
function GO(e){
var v=GE(e);
return v.options[v.selectedIndex].value;
}
function SS(e,s){
GE(e).style.display=s?"inline":"none";
}
function GS(e){
return GE(e).style.display!="none";
}
function SI(e,v){
GE(e).style.visibility=v?"visible":"hidden";
}
function GI(e){
return GE(e).style.visibility!="hidden";
}
function FS(e){
GE(e).focus();
GE(e).select();
}
function SR(e,s){
GE(e).className=s?"showrows":"hiderows";
}
function SH(e,h){
GE(e).innerHTML=h;
}
function ST(e,t){
GE(e).innerHTML=EH(t);
}
function NE(s){
return s.replace(/\r\n?/g,"\n");
}
function EH(v){
return v.replace(/&/g,"&amp;").replace(/"/g,"&quot;").replace(/</g,"&lt;").replace(/>/g,"&gt;");
}
function EL(v){
return v?EH(v.replace(/\n/g,"^$")).replace(/\^\$/g,"<BR>"):"";
}
function DT(){
return (new Date()).getTime();
}
function BR(_1b,_1c,_1d){
var url=_1b+"ap_"+_1c+".php?";
for(var j in _1d){
if(_1d[j]!=null){
url+=(j+"="+escape(_1d[j])+"&");
}
}
return url;
}
function BA(_20,_21,_22){
return BR(_20,_21,_22)+"_="+(DT()+Math.random());
}
function AG(_23,_24,_25,_26){
new Ajax.Request(BA("ap/",_23,_24),{method:"post",onComplete:function(_27){
_25(_23,_26,((_27.status==200)&&_27.responseText)?eval("("+_27.responseText+")"):{});
}});
}
function AP(_28,_29,_2a,_2b,_2c){
new Ajax.Request(BA("ap/",_28,_29),{method:"post",postBody:_2a,onComplete:function(_2d){
_2b(_28,_2c,((_2d.status==200)&&_2d.responseText)?eval("("+_2d.responseText+")"):{});
}});
}
var Bw=null;
function CE(w){
Bw=w;
window.onerror=SE;
}
function TR(){
var s="";
for(var a=TR;a;a=a.caller){
s+=(a.name||a.toString().match(/function (\w*)/))+"<";
if(a.caller==a){
break;
}
}
return s;
}
function SE(m,u,l,w){
w=w||window;
if(Bw){
if(Bw.SE){
Bw.SE(m,u,l,w);
}
}else{
AP("log_js_error",{},m+"|"+(w?w.location:"")+"|"+u+"|"+l+"|",function(){
},null);
}
}
function RE(e){
alert(e);
}
function SC(n,v){
var d=new Date();
d.setTime(d.getTime()+365*86400000);
document.cookie=n+"="+v+"; expires="+d.toGMTString()+"; path=/";
}
function GC(n){
var cs=document.cookie.split(";");
for(var j=0;j<cs.length;j++){
var c=cs[j];
while(c.charAt(0)==" "){
c=c.substring(1,c.length);
}
if(c.substring(0,n.length+1)==(n+"=")){
return c.substring(n.length+1,c.length);
}
}
return null;
}
function UL(l){
var dw=self.screen.width,dh=self.screen.height;
if(top.innerHeight){
dw=top.innerWidth;
dh=top.innerHeight;
}else{
if(top.document.documentElement&&top.document.documentElement.clientHeight){
dw=top.document.documentElement.clientWidth;
dh=top.document.documentElement.clientHeight;
}else{
if(top.document.body){
dw=top.document.body.clientWidth;
dh=top.document.body.clientHeight;
}
}
}
var w=window.open(l.href,"uplink","toolbar=1,location=1,status=1,menubar=1,scrollbars=1,resizable=1,"+"width="+(dw-64)+",height="+(dh-64));
if(w){
w.focus();
}
return !w;
}
