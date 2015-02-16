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

function ShS(i){
if(i){
var p=parent.Efa[i];
if(p){
ST("personname1",p.n);
if(GE("personname2")){
ST("personname2",(p.p||"")+" "+(p.l||p.q||""));
ST("personname3",(p.p||"")+" "+(p.l||p.q||""));
SV("toname",p.n);
SV("toemail",p.e);
FS("toemail");
}
}
}
}
