<?php

$baseUrl = 'http://website.kvomahajan.com';

parse_str(urldecode($_GET["token"]), $output);

$t = $output['t'];
$l = $output['l'];
$u = $output['u'];

if (isset($_GET['full'])) {	
	$json_data = file_get_contents('http://kvo.quadzero.in/people/index/export_as_json:1/full_tree:1/?full_tree=1');
} else if (isset($_GET['group_id'])){
	$json_data = file_get_contents('http://kvo.quadzero.in/people/index/export_as_json:1/group_id:' . $_GET['group_id']);
} else {
	//$json_data = file_get_contents('http://10.50.249.127/kvoadmin/family/buildTreeJson?gid=' . $_GET['gid'] . ' &uid=1');
        $json_data = file_get_contents($baseUrl.'/family/buildTreeJson?gid=' . $_GET["gid"] . '&token='.$t);
}
$welcomeUser = file_get_contents($baseUrl.'/family/getPeopleName?user_id='.$u);

$auth = (isset($u) && $u != '') ? true : false;
?>

<HTML>



	<HEAD>

		

<!--
<script type="text/javascript" src="http://10.50.249.127/tree/tree.json"></script>
	This Family Echo file is Copyright (c) Familiality Ltd.



	You are not permitted to distribute, copy, modify, merge, publish,

	sublicense, rent, sell, lease, loan, decompile, reverse engineer or

	create derivative works from this file.



	This copyright and license notice must be kept in this file at all times.

-->



		<LINK REL="stylesheet" TYPE="text/css" HREF="styles.css?130317">



		<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8">

		

		<TITLE>Family Tree</TITLE>

		

		<META NAME="Description" CONTENT="Draw your printable family tree online. Free and easy to use, no login required. Add photos and share with your family. Import/export GEDCOM files.">

                <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>/css/common.css" />
                <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>/css/bootstrap.min.css" />
                <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>/font-awesome-4.1.0/css/font-awesome.min.css" />
                <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>/css/bootstrap-select.min.css" />
                <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>/css/jquery-ui.min.css" />
	        <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>/css/jquery-ui.theme.min.css" />
                
                
                <script type="text/javascript" src="<?php echo $baseUrl; ?>/js/jquery-1.11.1.js"></script>
                <script type="text/javascript" src="<?php echo $baseUrl; ?>/js/bootstrap.min.js"></script>
                <script type="text/javascript" src="<?php echo $baseUrl; ?>/js/jquery-ui.min.js"></script>
                <script type="text/javascript" src="<?php echo $baseUrl; ?>/js/common.js"></script>

                <!-- Bootstrap Datepicker JavaScript -->
                <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>
                <!-- Bootstrap Select JavaScript -->
                <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.2/js/bootstrap-select.min.js"></script>

              
                
                <SCRIPT language="JavaScript"><!--

		var staticMode=false;

		var defaultZoom=1.25;

		var defaultDetail=null;

		var defaultBirthName=0;

		var defaultMiddleName=0;

		var defaultShowPhoto=0;

		var defaultCousins=2;

		var defaultChildren=8;

		var defaultParents=5;

		--></SCRIPT>



		<script src="prototype-ajax.js" type="text/javascript"></script>

		<script src="compress_all.js" type="text/javascript"></script>


	</HEAD>

	
	<BODY STYLE="overflow:hidden;" onLoad="PL();">
            <!--- layout menu starts -->
                                                
                <nav class="navbar navbar-default navbar-tree">
                    <div class="container-fluid">
                        <!-- Brand and toggle get grouped for better mobile display -->
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <a class="navbar-brand" href="<?php echo ($auth) ? $baseUrl . '/user/welcome' : $baseUrl  . $this->base; ?>"><img src="<?php echo $baseUrl; ?>/img/logo.png" height="30px"></a>
                        </div>
                        <!-- Collect the nav links, forms, and other content for toggling -->
                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                            <ul class="nav navbar-nav" id="right-top-links">
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle animate" data-toggle="dropdown" role="button" aria-expanded="false">Activities <span class="caret"></span></a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="#"><i class="fa fa-globe fa-fw"></i>About Us</a></li>
                                        <li><a href="#">KVOS Jain Mahajan's Constitution</a></li>
                                        <li><a href="#">Mission and Vission</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Interact <span class="caret"></span></a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="#">Events</a></li>
                                        <li><a href="#">Just Married</a></li>
                                        <li><a href="#">Babies</a></li>
                                        <li><a href="#">Obituaries</a></li>
                                        <li><a href="#">New Members</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Community <span class="caret"></span></a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="#">Matrimonial</a></li>
                                        <li><a href="#">Classifieds</a></li>
                                        <li><a href="#">Jobs</a></li>
                                        <li><a href="<?php echo $baseUrl . '/article'; ?>">Articles</a></li>
                                        <li><a href="#">Community Pages</a></li>
                                        <li><a href="#">Community Publications</a></li>
                                    </ul>
                                </li>
                                <?php if ($auth) { ?>
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">My Account <span class="caret"></span></a>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a href="#">Media</a></li>
                                            <li><a href="<?php echo $baseUrl . '/profile'; ?>">Profile</a></li>
                                            <li><a href="<?php echo $baseUrl . '/family/details/'.$_GET['gid']; ?>">My Family</a></li>
                                            <li><a href="<?php echo $baseUrl . '/tree?gid=' . $_GET['gid'] . '&token=' . $_GET['token']; ?>">My Tree</a></li>
                                        </ul>
                                    </li>
                                <?php } ?>
                            </ul>
                            <!-- people search -->
                            <div class="col-sm-3 col-md-3 text-center">
                                <form class="navbar-form" role="search">
                                    <div class="input-group">
                                        <input type="text" id="searchBox" class="form-control search_box" placeholder="Search People" name="srch-term" id="srch-term">
                                        <div class="input-group-btn">
                                            <button class="btn btn-default searchnow btn-tree" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <ul class="nav navbar-nav navbar-right">
                                <?php if ($auth) { ?>
                                    <li>Welcome <?php echo $welcomeUser; ?></li>
                                <?php } ?>
                                <li class="dropdown">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                        <i class="fa fa-language fa-fw"></i>  <i class="fa fa-caret-down"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-alerts">
                                        <li <?php echo ($l == md5('english')) ? 'class="active"' : ''; ?>>
                                            <a href="javascript: void();" class="web_lang" lang="english">
                                                <div>
                                                    <i class="fa fa-fw"></i> English
                                                </div>
                                            </a>
                                        </li>
                                        <li <?php echo ($l == md5('hindi')) ? 'class="active"' : ''; ?>>
                                            <a href="javascript: void();" class="web_lang" lang="hindi">
                                                <div>
                                                    <i class="fa fa-fw"></i> हिन्दी
                                                </div>
                                            </a>
                                        </li>
                                        <li <?php echo ($l == md5('gujurati')) ? 'class="active"' : ''; ?>>
                                            <a href="javascript: void();" class="web_lang" lang="gujurati">
                                                <div>
                                                    <i class="fa fa-fw"></i> ગુજરાતી
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                    <!-- /.dropdown-alerts -->
                                </li>
                                <!-- /.dropdown -->
                                <li class="dropdown">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-user">
                                        <?php if ($auth) { ?>
                                            <li><a href="<?php echo $baseUrl . '/profile'; ?>"><i class="fa fa-user fa-fw"></i> User Profile</a></li>
                                            <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a></li>
                                            <li class="divider"></li>
                                        <?php } ?>
                                        <?php if (!$auth) { ?>
                                            <li><a href="<?php echo $baseUrl . '/user/signup'; ?>"><i class="fa fa-sign-in fa-fw"></i> Sign Up</a></li>
                                            <li><a href="<?php echo $baseUrl . '/user/login'; ?>"><i class="fa fa-sign-in fa-fw"></i> Login</a></li>
                                        <?php } ?>
                                        <?php if ($auth) { ?>
                                            <li><a href="<?php echo $baseUrl . '/user/logout'; ?>"><i class="fa fa-sign-out fa-fw"></i> Logout</a></li>
                                        <?php } ?>
                                    </ul>
                                    <!-- /.dropdown-user -->
                                </li>
                                <!-- /.dropdown -->
                            </ul>
                        </div>
                        <!-- /.navbar-collapse -->
                    </div>
                    <!-- /.container-fluid -->
                </nav>


                <!--- layout menu ends -->
		<TABLE WIDTH="100%" HEIGHT="100%" CELLSPACING=0 CELLPADDING=0 stype="display:none;">

			<TR style="display:none;" >

				<FORM NAME="topform" ACTION="./" METHOD="POST">

					<TD  VALIGN="middle">
                                                
                                            <TABLE WIDTH="100%" HEIGHT="100%" CELLSPACING=0 CELLPADDING=0><TR VALIGN="middle">

							<TD NOWRAP><FONT STYLE="font-size:28px;">		<SPAN ID="lfamilyname" style="display:none;"><FONT COLOR="#7F2020">Family</FONT></SPAN>&nbsp;<SPAN ID="lfamilyinfo" STYLE="font-size:12px;"></SPAN>

		

		<IFRAME ID="backframe" WIDTH="1" HEIGHT="1" FRAMEBORDER="0" SCROLLING="no"></IFRAME>

</FONT></TD>

							<TD ALIGN="right">



		<INPUT TYPE="hidden" ID="newscript" NAME="newscript" VALUE="">

		<INPUT TYPE="hidden" ID="personid" NAME="personid" VALUE="START">

		<INPUT TYPE="hidden" ID="viewpersonid" NAME="viewpersonid" VALUE="START">

		<INPUT TYPE="hidden" ID="viewmode" NAME="viewstate" VALUE="edit">

		<INPUT TYPE="hidden" ID="name" NAME="name" VALUE="">

		<INPUT TYPE="hidden" ID="email" NAME="email" VALUE="">

		

		<INPUT TYPE="hidden" NAME="affiliate" VALUE="">

		<INPUT TYPE="hidden" ID="sessionid" VALUE="">

				<INPUT TYPE="hidden" ID="familyid" NAME="familyid" VALUE="">

		<INPUT TYPE="hidden" ID="importcacheid" NAME="importcacheid" VALUE="">

		<INPUT TYPE="hidden" ID="checksum" NAME="checksum" VALUE="">



		<INPUT TYPE="hidden" NAME="do_startbranch" ID="do_startbranch">

		

		<SPAN ID="lsave" STYLE="display:none;"><FONT COLOR="red"><B>Family not saved.</B></FONT> &nbsp; To save family, add photos, share and download:</SPAN>

		<SPAN ID="linitial" STYLE="display:none;">

<!--		    Want to save or retrieve a family?-->

		</SPAN>

		<SPAN ID="linitial" STYLE="display:none;">Welcome <B>amitgandhi23</B>.</SPAN>

		<SPAN ID="lreadonly" STYLE="display:none;"><FONT COLOR="red"><B>This family is read only.</B></FONT></SPAN>

		<SPAN ID="lwriteone" STYLE="display:none;"><FONT COLOR="red"><B>You may only edit your own details.</B></FONT> &nbsp; To edit other people or add more:</SPAN>

		<SPAN ID="lsaving" STYLE="display:none;">Changes being saved... </SPAN>

		<SPAN ID="lsaved" STYLE="display:none;">All changes saved. </SPAN>

		&nbsp;



		<SPAN ID="savefamily" STYLE="display:none;"><INPUT TYPE="submit" VALUE="Save" CLASS="ibutton" onClick="ESS(); return false;"> &nbsp;</SPAN>



		<SPAN ID="sharefamily" STYLE="display:none;"><INPUT TYPE="submit" VALUE="Share" CLASS="ibutton" onClick="ESM('share'); return false;"> &nbsp;</SPAN>



                <INPUT style="display: none;" TYPE="submit" NAME="do_signin" ID="do_signin" VALUE="Sign In" CLASS="ibutton" onClick="ESC(); return true;">

							</TD>

						</TR></TABLE>

					</TD>

				</FORM>

			</TR>

		

		<TR HEIGHT="*"><TD STYLE="position:relative;">

			

			<SCRIPT TYPE="text/javascript"><!--

				document.write('<DIV ID="noajax"'+(document.getElementById ? ' STYLE="display:none;"' : '')+'><TABLE HEIGHT="100%" WIDTH="100%"><TR><TD ALIGN="center"><FONT COLOR="red"><B>Sorry. This site requires a modern web browser such as Firefox, Internet Explorer 6+ or Safari.</B></FONT></TD></TR></TABLE></DIV>');

			--></SCRIPT>

			

			<NOSCRIPT>

				<TABLE HEIGHT="100%" WIDTH="100%"><TR><TD ALIGN="center">

					<FONT COLOR="red"><B>

					Sorry - this site requires JavaScript in order to display your family.

					<P>

					If a security warning has appeared at the top of the browser window,

					please click it to allow blocked content.

					<P>

					Otherwise, please switch on JavaScript in the Options... window of your browser.

					</B></FONT>

				</TD></TR></TABLE>

			</NOSCRIPT>

			

			<DIV CLASS="fullsize" STYLE="position:relative;">



				<DIV ID="treediv" CLASS="dright" STYLE="top:0px; height:100%; overflow:hidden;"><DIV ID="treemargin" CLASS="marginon"><IFRAME NAME="treeframe" ID="treeframe" SRC="tree.htm?130317" CLASS="fullsize" FRAMEBORDER="0" SCROLLING="no"></IFRAME></DIV></DIV>

				

				<DIV ID="navdiv" CLASS="dright" STYLE="bottom:0px; height:135px;"><DIV ID="navmargin" CLASS="marginon"><IFRAME NAME="navframe" ID="navframe" SRC="navigation.htm?1303171" CLASS="fullsize" FRAMEBORDER="0" SCROLLING="no"></IFRAME></DIV></DIV>

				

				<DIV ID="keydiv" CLASS="dright rbody" STYLE="bottom:64px; display:none; border-top:solid #666666 1px; padding:24px 0px 32px 0px; text-align:center;"><DIV ID="keymargin" CLASS="marginon"><DIV STYLE="font-size:14px; font-weight:bold; margin-bottom:24px;">Key to family tree diagram:</DIV><DIV STYLE="position:relative; margin:0 auto;" ID="keycontent"></DIV></DIV></DIV>



				<DIV ID="externaldiv" CLASS="dright" STYLE="top:0px; height:100%; display:none;"><DIV ID="externalmargin" CLASS="marginon" STYLE="background-color:white;"><IFRAME ID="externalurl" CLASS="fullsize" FRAMEBORDER="0" SCROLLING="auto"></IFRAME></DIV></DIV>



				<DIV style="display: none;" ID="welcomediv" STYLE="position:absolute; width:100%; top:16px;"><DIV ID="welcomemargin" CLASS="marginon"><CENTER>



				<TABLE CLASS="mbody" STYLE="margin:8px;" CELLSPACING="6">

					<TR><TD STYLE="font-size:18px; font-weight:bold;" ALIGN="center"><SPAN STYLE="float:right; font-size:10px;"><A HREF="#" onClick="EHW(); return false;">[X]</A></SPAN>&nbsp; Welcome to Family Tree!</TD></TR>





<!--					<TR><TD ALIGN="center">Start your family tree by entering your name on the left.</TD></TR>

					<TR><TD ALIGN="center">Then add parents, children, partners, siblings and more.</TD></TR>

					<TR><TD ALIGN="center">You can also <A HREF="#" onClick="ESM('import'); return false;">import</A> from GEDCOM or FamilyScript format.</TD></TR>

					<TR><TD ALIGN="center"><A HREF="#" onClick="GE('do_signin').click(); return false;">Sign in</A> to save your family, add photos, share and download.</TD></TR>





					<TR><TD ALIGN="center">Information is <A HREF="./?page=policies" TARGET="_new" onClick="return UL(this);">private</A> and only shown to invited family members.</A></TD></TR>

					<TR><TD ALIGN="center">Enjoy the site and <A HREF="./?page=feedback" TARGET="_new" onClick="return UL(this);">tell us</A> what you think!</TD></TR>-->

				</TABLE>

				</CENTER></DIV></DIV>

				

				<DIV ID="leftdiv" CLASS="dleft"><IFRAME NAME="sideframe" ID="sideframe"  SRC="sidebar.htm?130317" CLASS="fullsize" FRAMEBORDER="0" SCROLLING="no"></IFRAME></DIV>



				<DIV ID="extradiv" CLASS="dleft lbody"><IFRAME ID="extraframe" NAME="extraframe" CLASS="fullsize" FRAMEBORDER="0" SCROLLING="auto"></IFRAME></DIV>

				

			</DIV>



		</TD></TR>



                <TR style="display: none;" HEIGHT="8">

				<TD STYLE="border-top:solid #666666 1px; padding:8px;" VALIGN="middle">

					<DIV STYLE="float:left;">

						<SPAN ID="lfooterlinks">

<!--							<A HREF="./?page=about" TARGET="_new" onClick="return UL(this);" TITLE="About Family Echo">About</A>

							&nbsp; &nbsp;

							<A HREF="./?page=faqs" TARGET="_new" onClick="return UL(this);" TITLE="Frequently Asked Questions">FAQs</A>

							&nbsp; &nbsp;

							<A HREF="./?page=api" TARGET="_new" onClick="return UL(this);" TITLE="Family Tree API">API</A>

							&nbsp; &nbsp;

							<A HREF="http://www.magicbabynames.com/" TARGET="_new" onClick="return UL(this);" TITLE="Baby Names from Family Trees">Baby Names</A>

							&nbsp; &nbsp;

							<A HREF="./?page=resources" TARGET="_new" onClick="return UL(this);" TITLE="Genealogy Links and Information">Resources</A>

							&nbsp; &nbsp;

							<A HREF="./?page=terms" TARGET="_new" onClick="return UL(this);" TITLE="Terms of Use Agreement">Terms</A>

							&nbsp; &nbsp;

							<A HREF="./?page=policies" TARGET="_new" onClick="return UL(this);" TITLE="Privacy and Download Policies">Data Policies</A>

							&nbsp; &nbsp;

							<A HREF="./?page=feedback" TARGET="_new" onClick="return UL(this);" TITLE="How can we improve Family Echo?">Send Feedback</A>-->

						</SPAN>

					</DIV>

					<DIV STYLE="float:right;">Footer

						</DIV>

				</TD>

			</TR>

		</TABLE>


	</BODY>

<script type="text/javascript">
    var navshowdetail;
    var navshowparents;
    var navshowchildren;
    var navshowcousins;
    var navreload = false;
    var self = this;
    var cid = '';
    var baseUrl = '<?php echo $baseUrl; ?>';

    function setJSONValue() {       
         
        var data = '<?php echo $json_data ?>';
        var parsedData = JSON.parse(data);
        document.getElementById('lfamilyname').innerHTML = 'Family of '  + parsedData['parent_name'];
        
        window.frames[3].parent.Efa= parsedData['tree'];
    }

    //setTimeout("setJSONValue()",2000);    
     setJSONValue();
    
    function resetJSONValue(id) {
        if (id != 'START'){
            cid = id;
            navreload = true;    
            navshowdetail = window.navframe.document.getElementById('showdetail').value;
            navshowparents = window.navframe.document.getElementById('showparents').value;
            navshowchildren = window.navframe.document.getElementById('showchildren').value;
            navshowcousins = window.navframe.document.getElementById('showcousins').value;

            new Ajax.Request('<?php echo $baseUrl; ?>/family/buildFamilyJson?id='+id, {
                method: 'get',
                onComplete:function(_2d){
                    data = _2d.responseText;
                    var parsedData = JSON.parse(data);
                    window.frames[3].parent.Efa= parsedData['tree'];
        
                    var treeframe = document.getElementById("treeframe");
                    if (treeframe) {
                        var treeframeContent = (treeframe.contentWindow || treeframe.contentDocument);

                        treeframeContent.CE(this); 
                        treeframeContent.TIS(treeframeContent.document.getElementById('treebg')); 
                    }


                    var navframe = document.getElementById("navframe");
                    if (navframe) {
                        var navframeContent = (navframe.contentWindow || navframe.contentDocument);

                        navframeContent.PL(); 
                    }

                    var sideframe = document.getElementById("sideframe");
                    if (sideframe) {
                        var sideframeContent = (sideframe.contentWindow || sideframe.contentDocument);

                        sideframeContent.PL(); 
                    }
                    document.getElementById('lfamilyname').innerHTML = 'Family of '  + parsedData['parent_name'];
                    window.navframe.NCP(parseInt(parsedData['count']));
                }
            });
        }
    }
</script>

</HTML>
