
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

var Fmn=["","Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
var Fgn={"":"","f":"Female","m":"Male"};
function FAA(a,v){
a[a.length]=v;
}
function FRF(f,ap,fp){
for(var i in f){
var p=f[i];
p.c=[];
p.pc={};
p.fg=false;
if(p.m&&!f[p.m]){
p.m=null;
}
if(p.f&&!f[p.f]){
p.f=null;
}
if(p.s&&!f[p.s]){
p.s=null;
}
if(p.s){
p.pc[p.s]=true;
}
if(p.ep){
for(var j in p.ep){
if(p.ep[j]&&f[j]){
p.pc[j]=true;
}
}
}
}
var ai=0;
for(var i in f){
var p=f[i];
var mi=p.m;
var fi=p.f;
p.i=i;
p.h=null;
p.n=null;
p.hp=false;
ai++;
p.ai=ai;
if(p.p){
var _c=p.p.split(" ");
for(j=0;j<_c.length;j++){
if(_c[j].length){
p.h=_c[j];
var sn=p.l||p.q;
p.n=p.h+(sn?(" "+sn):"");
p.hp=true;
break;
}
}
}
if(mi&&fi){
f[mi].pc[fi]=true;
f[fi].pc[mi]=true;
}
if(mi){
FAA(f[mi].c,i);
}
if(fi){
FAA(f[fi].c,i);
}
}
for(var i in f){
var p=f[i];
var mi=p.m;
var fi=p.f;
if(!p.h){
if(i==ap){
p.h="Me";
}else{
if(i==fp){
p.h="Founder";
}else{
var r=p["^"];
if(r&&f[r]&&f[r].h){
if((r==mi)||(r==fi)){
p.h=FPT(f[r],((p.g=="f")?"Daughter":((p.g=="m")?"Son":"Child")));
}else{
if(f[r].m==i){
p.h=FPT(f[r],"Mother");
}else{
if(f[r].f==i){
p.h=FPT(f[r],"Father");
}else{
if((mi&&(f[r].m==mi))||(fi&&(f[r].f==fi))){
p.h=FPT(f[r],(((f[r].m==mi)&&(f[r].f==fi))?"":"Half ")+((p.g=="f")?"Sister":((p.g=="m")?"Brother":"Sibling")));
}else{
if(r==p.s){
p.h=FPT(f[r],"Partner");
}else{
if(f[r].pc[i]){
p.h=FPT(f[r],"Ex-partner");
}
}
}
}
}
}
}
}
}
if(!p.h){
p.h="Anon "+p.ai;
}
p.n=p.h;
}
p.cp=0;
for(var pi in p.pc){
p.cp++;
}
p.es=p.s||((p.cp==1)?pi:null);
}
if(fp){
FSR(f,fp,"fg",true,true,true,true,true,false);
}
}
function FSR(f,i,l,u,uu,d,dd,a,aa){
if(i&&f[i]&&!f[i][l]){
var p=f[i];
p[l]=true;
if(u){
FSR(f,p.m,l,uu,uu,dd,dd,aa,aa);
FSR(f,p.f,l,uu,uu,dd,dd,aa,aa);
}
if(d){
for(var j=0;j<p.c.length;j++){
FSR(f,p.c[j],l,false,false,dd,dd,aa,aa);
}
}
if(a){
FSR(f,p.es,l,uu,uu,dd,dd,aa,aa);
for(var pi in p.pc){
FSR(f,pi,l,uu,uu,dd,dd,aa,aa);
}
}
}
}
function FDF(f,i,si,sf,st){
for(var j in f){
f[j].cf=false;
}
FCF(f,i,"cf",null,si,sf,st);
var df=[];
for(var j in f){
if(!f[j].cf){
df[df.length]=j;
}
}
return df;
}
function FCF(f,i,l,fi,si,sf,st){
if(i&&f[i]&&!f[i][l]&&(i!=si)&&((i!=st)||(fi!=sf))){
var p=f[i];
p[l]=true;
FCF(f,p.m,l,i,si,sf,st);
FCF(f,p.f,l,i,si,sf,st);
for(var j=0;j<p.c.length;j++){
FCF(f,p.c[j],l,i,si,sf,st);
}
for(var pi in p.pc){
FCF(f,pi,l,i,si,sf,st);
}
}
}
function FCS(f,i){
for(var j in f){
f[j].sf=false;
}
FSR(f,i,"sf",true,true,true,true,false,true);
FSR(f,f[i].es,"sf",false,false,true,true,false,true);
for(var pi in f[i].pc){
FSR(f,pi,"sf",false,false,true,true,false,true);
}
var sf=[];
for(var j in f){
if(f[j].sf){
sf[sf.length]=j;
}
}
return sf;
}
function FMS(f,mi,fi){
return f[mi]&&f[fi]&&(f[mi].s==fi)&&(f[fi].s==mi);
}
function FGM(g){
return (g=="f")?-1:((g=="m")?1:0);
}
function FCM(p1,p2){
return (p1?FGM(p1.g):0)-(p2?FGM(p2.g):0);
}
function FSM(f,i,si){
var cm=FCM(i?f[i]:null,si?f[si]:null);
return cm?(cm<0):(si?(i<si):false);
}
function FIG(g){
return (g=="m")?"f":((g=="f")?"m":null);
}
function FPR(f,i){
var p=f[i];
for(var j in f){
f[j].rf=false;
}
FSR(f,i,"rf",false,false,true,true,false,false);
f[i].rf=false;
FSR(f,i,"rf",false,false,false,false,true,false);
FSR(f,p.m,"rf",true,true,true,false,false,false);
FSR(f,p.f,"rf",true,true,true,false,false,false);
var ra=[];
for(var j in f){
if(!f[j].rf){
FAA(ra,j);
}
}
return ra;
}
function FAR(f,i,si){
for(var j in f){
f[j].pf=false;
}
for(var pi in f[i].pc){
FSR(f,pi,"pf",true,false,false,false,false,false);
}
FSR(f,i,"pf",false,false,true,true,false,false);
if(si){
FPR(f,si);
}
var pa=[];
for(var j in f){
if((!f[j].pf)&&((!si)||f[si].pc[j]||(!f[j].rf))){
FAA(pa,j);
}
}
return pa;
}
function FPD(d){
return {d:parseInt(d.substring(6,8),10),m:parseInt(d.substring(4,6),10),y:parseInt(d.substring(0,4),10)};
}
function FDT(d){
var p=FPD(d?d.toString():"");
return (p.m?((p.d?(p.d+" "):"")+Fmn[p.m]+" "):"")+(p.y?p.y:"");
}
function FDE(v,m,l){
v=parseInt(v);
v="0000"+((isNaN(v)||(v<0))?0:((v>m)?m:v));
return v.substring(v.length-l,v.length);
}
function FDS(d,m,y){
return FDE(y,9999,4)+FDE(m,12,2)+FDE(d,31,2);
}
function FPT(p,r){
return r+" of "+p.h;
}
function FCC(p1,p2){
var b1=(p1.b&&parseInt(p1.b.substring(0,4),10))?parseInt(p1.b,10):99999999;
var b2=(p2.b&&parseInt(p2.b.substring(0,4),10))?parseInt(p2.b,10):99999999;
if(b1<b2){
return -1;
}else{
if(b2<b1){
return 1;
}
}
if(p1.ai<p2.ai){
return -1;
}else{
if(p1.ai>p2.ai){
return 1;
}
}
return 0;
}
function FSC(f,ci){
var cp=[];
for(var j=0;j<ci.length;j++){
cp[cp.length]=f[ci[j]];
}
cp.sort(FCC);
ci.length=0;
for(var j=0;j<cp.length;j++){
ci[ci.length]=cp[j].i;
}
}
function FLA(f,i){
var ac=[];
var c=f[i].c;
for(var j=0;j<c.length;j++){
var cp=f[c[j]];
if(!(cp.m&&f[cp.m]&&cp.f&&f[cp.f])){
FAA(ac,c[j]);
}
}
FSC(f,ac);
return ac;
}
function FLP(f,i,pi){
var tc=[];
var c=f[i].c;
for(var j=0;j<c.length;j++){
var cp=f[c[j]];
if(((cp.m==i)&&(cp.f==pi))||((cp.f==i)&&(cp.m==pi))){
FAA(tc,c[j]);
}
}
FSC(f,tc);
return tc;
}
function FLS(f,i){
var bs=[];
var mi=f[i].m;
var fi=f[i].f;
var cs={};
if(mi&&f[mi]){
var c=f[mi].c;
for(var j=0;j<c.length;j++){
cs[c[j]]=true;
}
}
if(fi&&f[fi]){
var c=f[fi].c;
for(var j=0;j<c.length;j++){
cs[c[j]]=true;
}
}
for(var j in cs){
if(j!=i){
if(((f[j].m==mi)&&(f[j].f==fi))||((f[j].m==fi)&&(f[j].f==mi))){
FAA(bs,j);
}
}
}
FSC(f,bs);
return bs;
}

var Efa={};
var Efo;
var Ewr;
var Ewp=null;
var Ead;
var Eve;
var Ezf,Esd=null,Ebn=false,Emn=false,Esp=false;
var Eeq=[];
var Esc=false;
var Ess="",Eis="";
var Eec=null;
var Epc=null;
var staticModeAfterRead;
var Elb=null;
var Ebi;
var Esb;
var Elh=null;
function PL(){
if(!staticMode){
CE();
}
if(staticMode||((typeof (Ajax)!="undefined")&&Ajax.getTransport())){
window.onbeforeunload=EPU;
var c=GC("zoomfactor");
var zf=parseFloat((c===null)?defaultZoom:c);
Ezf=((zf>=0.25)&&(zf<=2))?zf:1.25;
var c=GC("showbirthname");
Ebn=parseInt((c===null)?defaultBirthName:c)?true:false;
var c=GC("showmiddlename");
Emn=parseInt((c===null)?defaultMiddleName:c)?true:false;
var c=GC("showphoto");
Esp=parseInt((c===null)?defaultShowPhoto:c)?true:false;
var c=GC("showdetail");
Esd=(c===null)?defaultDetail:c;
self.navframe.NSD(Esd);
var c=GC("showcousins");
self.navframe.NSC((c===null)?defaultCousins:c);
var c=GC("showchildren");
self.navframe.NSH((c===null)?defaultChildren:c);
var c=GC("showparents");
self.navframe.NSA((c===null)?defaultParents:c);
Ebi=(document.all&&(navigator.userAgent.toLowerCase().indexOf("msie")>=0));
Esb=(navigator.userAgent.toLowerCase().indexOf("safari")>=0);
if(staticMode){
Ewr=false;
Efo=GV("founderid");
ERP(false);
}else{
Ewr=true;
Ead=true;
Efo=GV("personid");
var fi=GV("familyid");
var ic=GV("importcacheid");
if(fi||ic){
AG("family_read",{f:fi,i:ic,p:GV("personid"),c:GV("checksum"),s:GV("sessionid")},EFR,fi&&(ic||GV("newscript").length));
}else{
ERP(false);
}
}
}else{
SS("treeframe",false);
SS("noajax",true);
}
}
function ESB(l){
if(!Esb){
if(Ebi){
Elh=l;
setTimeout("GE('backframe').src='back.htm?"+l+"';",100);
}else{
window.location.hash=l;
}
}
}
function EBI(l){
var h=new String(l.search);
var p=h.lastIndexOf("?");
if(p>=0){
h=h.substring(p+1);
}
if(Elh&&(Elh!=h)){
return;
}
Elh=null;
window.location.hash=h;
}
function EBT(){
if(!Esb){
var h=new String(window.location.hash);
if(h.length&&(h.charAt(0)=="#")){
h=h.substring(1);
}
if(Elh&&(Elh!=h)){
return;
}
var a=h.split(":");
var m=a[0];
var i=a[1];
if((i&&(i!=GV("viewpersonid")))||(m&&(m!=GV("viewmode")))){
if((Eec!==null)&&(i==Epc)&&(m==="view")){
EFE(false);
}else{
if(i&&Efa[i]){
SV("viewpersonid",i);
}
if(m){
SV("viewmode",m);
}
EUS(false,null,null,true,true);
}
}
}
}
function EPU(e){

}
function ESC(){
Esc=true;
}
function EFR(_f,_10,_11){
if(_11.ok){
Efa={};
if(_11.f){
if(_11.ar){
ERS(_11.t);
Ess=_11.t;
Eve=_11.v;
Ewr=_11.aw;
Ewp=_11.pw?GV("personid"):null;
Ead=_11.aa;
Efo=_11.fp;
}else{
RE("You do not have permission to view this family");
}
}
if(_11.m){
ERS(_11.m);
Eis=_11.m;
if(_11.ro){
staticMode=true;
staticModeAfterRead=true;
Ewr=false;
Ewp=false;
SS("do_signin",false);
SH("lfooterlinks","Family displayed via the <A HREF=\"http://www.familyecho.com/\">Family Echo</A> API.");
}
if(_11.lo){
SH("lfamilyname",_11.lo);
}
}
}else{
RE("This family could not be located");
}
ERP(_10);
}
function ERP(_12){
ERS(GV("newscript"));
if(Esd===null){
Esd="";
for(var j in Efa){
if(Efa[j].r){
Esp=true;
}
}
self.navframe.NSD(Esd);
}
EUS(true,null,GV("viewmode"),true,false);
if(_12){
ESS();
}else{
EUL(false);
}
setInterval(EBT,250);
}
function EUS(r,i,m,d,s){
var pi=Evp=GV("viewpersonid");
var pm=viewMode=GV("viewmode");
if(r){
var ap=GV("personid");
if(Efo&&!Efa[Efo]){
Efa[Efo]={};
}
FRF(Efa,ap,Efo);
if(ap&&Efa[ap]){
self.navframe.NSP(ap);
SV("name",Efa[ap].n);
SV("email",Efa[ap].e);
}else{
self.navframe.NSP(Efo);
}
var fc=0;
for(var j in Efa){
fc++;
}
self.navframe.NCP(fc);
if(staticMode||GV("familyid")){
ST("lfamilyinfo",(Efo&&Efa[Efo])?("Family of "+Efa[Efo].n):"");
}
}
if(i){
Evp=i;
}
if(m){
viewMode=m;
}
if((!Evp)||(!Efa[Evp])){
if(Efo&&Efa[Efo]){
Evp=Efo;
}else{
for(Evp in Efa){
break;
}
}
}
SV("viewpersonid",Evp);
SV("viewmode",viewMode);
if(viewMode=="share"){
ESI(true);
GE("extraframe").src="share.php?f="+escape(GV("familyid"))+"&p="+escape(GV("personid"))+"&c="+escape(GV("checksum"))+"&i="+escape(Evp)+"&s="+escape(GV("sessionid"))+"&z="+((Efa[Evp].z!="1")?0:1);
SI("extradiv",true);
}else{
if(viewMode=="download"){
ESI(true);
GE("extraframe").src="download.php?f="+escape(GV("familyid"))+"&p="+escape(GV("personid"))+"&c="+escape(GV("checksum"))+"&s="+escape(GV("sessionid"));
SI("extradiv",true);
}else{
if(viewMode=="print"){
ESI(true);
if(m){
GE("extraframe").src="print.php?f="+escape(GV("familyid"))+"&p="+escape(GV("personid"))+"&c="+escape(GV("checksum"))+"&s="+escape(GV("sessionid"));
}
SI("extradiv",true);
}else{
if(viewMode=="import"){
ESI(true);
GE("extraframe").src="import.php?p="+escape(GV("personid"));
SI("extradiv",true);
}else{
if(viewMode=="importfinish"){
}else{
if(GI("extradiv")){
GE("extraframe").src="";
SI("extradiv",false);
}
}
}
}
}
}
self.sideframe.SSE(Evp,viewMode);
var uf=(viewMode=="website")?"w":((viewMode=="blog")?"B":((viewMode=="photos")?"P":null));
if(uf){
GE("externalurl").src=Efa[Evp][uf];
SS("externaldiv",true);
self.sideframe.SSU(true);
}else{
if(GS("externaldiv")){
SS("externaldiv",false);
GE("externalurl").src="";
self.sideframe.SSU(false);
}
}
if(i||m){
ESB(viewMode+":"+Evp);
}
if(d||(Evp!=pi)){
self.treeframe.TRT(Efa,Evp,GV("personid"),Esd,Ebn,Emn,Esp,self.navframe.NGH(),self.navframe.NGA(),self.navframe.NGC(),pi,Ezf,s);
self.navframe.NRT();
}
}
function EUF(){
EUS(true,null,null,true,false);
}
function ERF(){
EUS(false,null,null,true,true);
}
function ESP(i,s){
EHW();
for(var j=0;j<(Eeq.length-1);j++){
if(Eeq[j]==i){
Eeq.splice(j,1);
EUS(false,i,"edit",false,s);
return;
}
}
var vm=GV("viewmode");
Eeq=[];
EUS(false,i,((vm=="share")||(vm=="print"))?null:"view",false,s);
}
function ESM(m){
EUS(false,null,m,false,false);
}
function ECS(){
Eec=GV("newscript").length;
Epc=GV("viewpersonid");
}
function ESE(r,i,b){
Eeq=[];
for(var j=1;j<i.length;j++){
Eeq[Eeq.length]=i[j];
}
Eeq[Eeq.length]=b;
EHW();
EUS(r,i[0],"edit",r,true);
}
function EFE(a){
if(a){
if(Eeq.length<=1){
ESS();
EHW();
EUS(false,Eeq.length?Eeq[0]:null,"view",false,true);
Eec=null;
}else{
EUS(false,Eeq.shift(),"edit",false,true);
}
}else{
if(Eec!==null){
ESM("view");
Efa={};
ERS(Ess);
ERS(Eis);
var ks=GV("newscript");
ks=ks.substring(0,Eec);
SV("newscript",ks);
ERS(ks);
Eec=null;
EUS(true,Epc,"view",true,true);
}else{
EUS(true,null,"view",true,true);
}
EUL(false);
}
}
function EFV(i,p,v){
if(i){
Efa[i]=Efa[i]||{};
if((p=="x")||(p=="s")){
if(Efa[i].s&&Efa[Efa[i].s]){
Efa[Efa[i].s].s=null;
}
}
if(p=="x"){
delete Efa[i];
}else{
if((p=="s")&&v){
Efa[v]=Efa[v]||{};
if(Efa[v].s&&Efa[Efa[v].s]){
Efa[Efa[v].s].s=null;
}
Efa[v].s=i;
}
Efa[i][p]=v?v:null;
}
}
}
function EPV(i1,i2,p,v){
if(i1&&i2){
Efa[i1]=Efa[i1]||{};
Efa[i2]=Efa[i2]||{};
var fn=p+"p";
Efa[i1][fn]=Efa[i1][fn]||{};
Efa[i2][fn]=Efa[i2][fn]||{};
Efa[i1][fn][i2]=v.length?v:null;
Efa[i2][fn][i1]=v.length?v:null;
}
}
function ERS(s){
var c=ECL(s);
for(var j=0;j<c.length;j++){
var e=c[j];
var i=e.t.substring(1,e.t.length);
var v=e.v.replace(/\\t/g,"\t").replace(/\\n/g,"\n").replace(/\\\\/g,"\\");
if(e.t.charAt(0)=="i"){
EFV(i,e.p,v);
}else{
if(e.t.charAt(0)=="p"){
var ii=i.split(" ");
EPV(ii[0],ii[1],e.p,v);
}
}
}
}
function ECL(s){
var l=NE(s).split("\n");
var c=[];
for(var j=0;j<l.length;j++){
var e=l[j].split("\t");
for(var k=1;k<e.length;k++){
c[c.length]={t:e[0],p:e[k].charAt(0),v:e[k].substring(1,e[k].length)};
}
}
return c;
}
function EOS(s){
var c=ECL(s);
var os="";
var pi=null;
var pc=[];
for(var j=0;j<c.length;j++){
var e=c[j];
if(e.t!=pi){
if(pi){
os+=pi+"\t"+pc.join("\t")+"\n";
}
pi=e.t;
pc=[];
}
var pl=pc.length;
pc[((pl>0)&&(pc[pl-1].charAt(0)==e.p))?(pl-1):pl]=e.p+e.v;
}
if(pi){
os+=pi+"\t"+pc.join("\t")+"\n";
}
return os;
}
function EFC(i,c){
for(var p in c){
var v=c[p]?NE(new String(c[p])):"";
EFV(i,p,v);
GE("newscript").value+="\ni"+i+"\t"+p.charAt(0)+v.replace(/\\/g,"\\\\").replace(/\n/g,"\\n").replace(/\t/g,"\\t");
}
EUL(false);
}
function EPC(i1,i2,c){
for(var p in c){
var v=c[p]?NE(new String(c[p])):"";
EPV(i1,i2,p,v);
GE("newscript").value+="\np"+i1+" "+i2+"\t"+p.charAt(0)+v.replace(/\\/g,"\\\\").replace(/\n/g,"\\n").replace(/\t/g,"\\t");
}
EUL(false);
}
function EFI(){
var c="ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
for(var j=0;j<1000;j++){
var i="";
for(k=0;k<5;k++){
i+=c.charAt(Math.floor(Math.random()*(k?36:26)));
}
if(!Efa[i]){
break;
}
}
return i;
}
var Edf=false;
function ESS(){
if(!staticMode){
var fi=GV("familyid");
var ic=GV("importcacheid");
if(fi&&!Edf){
var len=GV("newscript").length;
if(len||ic){
Edf=true;
AP("family_append",{f:fi,i:ic,p:GV("personid"),c:GV("checksum"),v:Eve},EOS(GV("newscript")),ESR,len);
EUL(false);
}else{
Edf=true;
EUL(false);
Edf=false;
setTimeout("EUL(true);",500);
}
}
}
}
function ESR(_56,len,_58){
Edf=false;
if(_58.ok){
Eve=_58.v;
Ess+="\n"+Eis;
Eis="";
SV("importcacheid","");
var ns=GV("newscript");
Ess+=ns.substring(0,len);
SV("newscript",ns.substring(len,ns.length));
if(_58.t){
Efa={};
ERS(_58.t);
Ess=_58.t;
ERS(GV("newscript"));
EUS(true,null,null,true,false);
}
}else{
RE("The family could not be saved - please try again");
}
EUL(true);
}
function EUL(js){
if(!staticMode){
var len=GV("newscript").length;
var ic=GV("importcacheid");
if(Edf){
p="lsaving";
}else{
if(len||ic){
p="lsave";
}else{
if(!Ewr){
p=Ewp?"lwriteone":"lreadonly";
}else{
p=js?"lsaved":"linitial";
}
}
}
var es=["linitial","lreadonly","lwriteone","lsave","lsaving","lsaved"];
for(j=0;j<es.length;j++){
SS(es[j],p==es[j]);
}
var fi=GV("familyid");
var si=GV("sessionid");
SS("savefamily",(Ewr||len||ic)&&fi);
SS("sharefamily",Ewr&&si&&fi);
self.sideframe.SSF();
}
}
function EAS(){
AP("userfamily_add",{s:GV("sessionid"),f:GV("familyid"),p:GV("personid"),c:GV("checksum")},"",EAR,null);
}
function EAR(_60,_61,_62){
if(_62.ok){
ST("lfamilyname",_62.n);
SS("addfamily",false);
}else{
RE(_62.er||"The family could not be added");
}
}
function EBS(){
var ap=GV("personid");
ESP((ap&&Efa[ap])?ap:Efo,true);
}
function ECZ(zi){
if(zi&&(Ezf<2)){
Ezf+=0.25;
}else{
if((!zi)&&(Ezf>0.5)){
Ezf-=0.25;
}
}
SC("zoomfactor",Ezf);
ERF();
}
function ECD(d,bn,mn,sp){
if(d!==null){
SC("showdetail",d);
Esd=d;
}
if(bn!==null){
SC("showbirthname",bn?1:0);
Ebn=bn;
}
if(mn!==null){
SC("showmiddlename",mn?1:0);
Emn=mn;
}
if(sp!==null){
SC("showphoto",sp?1:0);
Esp=sp;
}
self.navframe.NSD(Esd);
ERF();
}
function ECO(){
SC("showcousins",self.navframe.NGC());
ERF();
}
function ECH(){
SC("showchildren",self.navframe.NGH());
ERF();
}
function ECP(){
SC("showparents",self.navframe.NGH());
ERF();
}
function ETK(){
var ns=!GS("keydiv");
if(ns){
KDK(GE("keycontent"));
}
SS("keydiv",ns);
self.navframe.NKS(ns);
}
function ETI(){
ESI(!GI("leftdiv"));
ERF();
}
function ESI(s){
var c=s?"marginon":"marginoff";
GE("treemargin").className=c;
GE("externalmargin").className=c;
GE("navmargin").className=c;
GE("welcomemargin").className=c;
GE("keymargin").className=c;
SI("leftdiv",s);
self.navframe.NSS(s);
}
function EFB(i){
var sf=FCS(Efa,i);
SV("do_startbranch",sf.join("\t"));
document.topform.submit();
}
function EIU(r){
if(staticMode){
return "image-"+r+".jpg";
}else{
return BR("ap/","image_read",{f:GV("familyid"),p:GV("personid"),c:GV("checksum"),r:r});
}
}
function EHW(){
SS("welcomediv",false);
}
function KDK(o){
var d=TND();
TAE(d,"m",{g:"m",h:"Blue is male"},0,0,false);
TAE(d,"f",{g:"f",h:"Pink is female"},1,0,false);
TAE(d,"w",{h:"Thick\nlines..."},0,1,false);
TAE(d,"h",{h:"...show partners"},1,1,false);
TAL(d,0,1,1,1,true);
TAE(d,"b",{g:"f",h:"Mother"},2.5,0,false);
TAE(d,"g",{g:"m",h:"Father"},3.5,0,false);
TAL(d,2.5,0,3.5,0,false);
TAE(d,"d",{g:"f",h:"Daughter"},2.5,1,false);
TAE(d,"s",{g:"m",h:"Son"},3.5,1,false);
TAL(d,3,0,3,0.5,false);
TAL(d,2.5,0.5,3.5,0.5,false);
TAL(d,2.5,0.5,2.5,1,false);
TAL(d,3.5,0.5,3.5,1,false);
TAE(d,"z",{h:"Deceased are faded",z:1},5,0,false);
TAE(d,"o",{h:"Dotted lines lead to more"},5,1,false);
TAL(d,5,1,5,0.6,null);
TAL(d,5,1,4.55,1,null);
TRD(d,"",false,false,false,o,null,false,false,1,null);
}
function ESL(){
return {s:Ess.length,i:Eis.length,n:GV("newscript").length};
}
function ECI(c,s){
EHW();
SV("importcacheid",c);
SV("newscript","");
Efa={};
Eis=s;
ERS(s);
EUS(true,null,"view",true,false);
EUL(false);
}
function ESA(){
SV("importcacheid","");
SV("newscript","");
Efa={};
Eis="";
EUS(true,null,"edit",true,false);
EUL(false);
SS("welcomediv",true);
}

var ios=navigator.userAgent.match(/(iPod|iPhone|iPad)/)&&navigator.userAgent.match(/AppleWebKit/);
function TND(){
return {l:0,r:0,w:0,t:0,b:0,h:0,e:{},n:[]};
}
function TAE(d,i,p,x,y,k){
var di=d.e[i];
if(di){
i+=Math.random(0,999999);
}
d.e[i]={p:p,x:x,y:y,k:k,d:di};
d.l=Math.min(d.l,x);
d.r=Math.max(d.r,1+x);
d.w=d.r-d.l;
d.t=Math.min(d.t,y);
d.b=Math.max(d.b,1+y);
d.h=d.b-d.t;
}
function TAL(d,x1,y1,x2,y2,k){
d.n[d.n.length]={x1:x1,y1:y1,x2:x2,y2:y2,k:k};
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
return {Tew:parseInt(((y||sp||mn)?100:80)*zf),Teh:parseInt((40+(y?40:0)+(sp?100:0))*zf),Tph:parseInt(100*zf),Tdh:parseInt(40*zf),Tmh:parseInt(40*zf),Ths:parseInt(20*zf),Tvs:parseInt((y?40:60)*zf),Tfs:parseInt(12*zf),Tds:parseInt(10*zf)};
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
if(oi&&o.ps[oi]&&d.e[oi]){
ox=o.ps[oi].x-d.e[oi].x*(sz.Tew+sz.Ths);
oy=o.ps[oi].y-d.e[oi].y*(sz.Teh+sz.Tvs);
}else{
ox=_25-d.l*(sz.Tew+sz.Ths);
oy=_26-d.t*(sz.Teh+sz.Tvs);
}
}
}
o.innerHTML="";
o.ps={};
o.es={l:(ox+(d.l-0.5)*(sz.Tew+sz.Ths)),t:(oy+(d.t-0.5)*(sz.Teh+sz.Tvs)),r:(ox+(d.r-0.5)*(sz.Tew+sz.Ths)),b:(oy+(d.b-0.5)*(sz.Teh+sz.Tvs))};
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
v.onmousedown=TCT;
v.id=i;
v.pid=e.p.i;
o.ps[i]={x:sx,y:sy};
}
var tn=e.p.hp?(mn?fn:(e.p.h+(sn?(" "+sn):""))):e.p.h;
v.innerHTML="<TABLE WIDTH=\"100%\" HEIGHT=\"100%\" STYLE=\"table-layout:fixed;\">"+"<TR><TD CLASS=\""+cc+"\" STYLE=\"font-size:"+(e.d?sz.Tds:sz.Tfs)+"px;\""+" TITLE=\""+(e.d?"Duplicate: ":"")+EH(fn)+"\">"+(e.d?"<I>Duplicate:</I><BR>":"")+(e.m?"<B>":"")+EL(tn)+(e.m?"</B>":"")+"</TD></TR>"+rs+"</TABLE>";
o.appendChild(v);
}
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
var as={l:sx+64,t:sy+32,r:sx+dw-32,b:sy+dh-64};
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
return {top:scrolltop,left:scrollleft};
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
Tsd={top:y,left:x};
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
