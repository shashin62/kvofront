<HTML>

	<HEAD>
		
<!--
	This Family Echo file is Copyright (c) Familiality Ltd.

	You are not permitted to distribute, copy, modify, merge, publish,
	sublicense, rent, sell, lease, loan, decompile, reverse engineer or
	create derivative works from this file.

	This copyright and license notice must be kept in this file at all times.
-->
		
		<LINK REL="stylesheet" TYPE="text/css" HREF="styles.css?130317">

		<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8">

		<TITLE>Family Echo - Share</TITLE>

		<script src="common.js?130317" type="text/javascript"></script>	
		<script src="share.js?130317" type="text/javascript"></script>	
	</HEAD>
	
	<BODY CLASS="lbody" STYLE="margin:12px;"
	 onLoad="ShS('START');" 	><CENTER>

	
		<FORM ACTION="share.php" METHOD="POST">

			<DIV STYLE="margin-top:12px;">
			Share this family with&nbsp;<B><SPAN ID="personname1"></SPAN></B>&nbsp;below
			or click on the tree to share with someone else.
			</DIV>
			
			<TABLE WIDTH="100%" CELLSPACING=0 CELLPADDING=0 STYLE="border:solid #666666 1px; margin-top:12px;">
				<TR><TD><IMG SRC="blankpixel.gif" WIDTH="1" HEIGHT="12"></TD></TR>

				<TR>
					<TD COLSPAN="2" CLASS="sboth"><B>Send an email from the server now:</B>					</TD>
				</TR>
				
				<TR><TD><IMG SRC="blankpixel.gif" WIDTH="1" HEIGHT="12"></TD></TR>
				
				<TR>
					<TD CLASS="sleft">
						To:
					</TD>
					<TD CLASS="sright">
						<INPUT NAME="toname" ID="toname" CLASS="sfield" VALUE="">
					</TD>
				</TR>
				
				<TR>
					<TD CLASS="sleft" NOWRAP>
						To email:
					</TD>
					<TD CLASS="sright">
						<INPUT NAME="toemail" ID="toemail" CLASS="sfield" VALUE="">
					</TD>
				</TR>
				
				<TR><TD><IMG SRC="blankpixel.gif" WIDTH="1" HEIGHT="6"></TD></TR>
				
				<TR>
					<TD CLASS="sleft">
						From:
					</TD>
					<TD CLASS="sright">
						<INPUT NAME="fromname" ID="fromname" CLASS="sfield" VALUE="Me">
					</TD>
				</TR>
				
				<TR>
					<TD CLASS="sleft" NOWRAP>
						From email:
					</TD>
					<TD CLASS="sright">
						<INPUT NAME="fromemail" ID="fromemail" CLASS="sfield" VALUE="amitgandhi23@gmail.com">
					</TD>
				</TR>
				
				<TR><TD><IMG SRC="blankpixel.gif" WIDTH="1" HEIGHT="6"></TD></TR>
				
				<TR>
					<TD CLASS="sleft" NOWRAP>
						Extra message&nbsp;<BR>(optional):
					</TD>
					<TD CLASS="sright">
						<TEXTAREA NAME="message" CLASS="sfield" ROWS="3"></TEXTAREA>
					</TD>
				</TR>
				
				<TR>
					<TD CLASS="sleft" NOWRAP>
					</TD>
					<TD CLASS="sright">
						<INPUT TYPE="hidden" NAME="writeableshown" VALUE="1">
						<INPUT TYPE="checkbox" NAME="writeable" ID="writeable" VALUE="1" CHECKED onClick="document.forms[0].submit();">
						Allow&nbsp;<SPAN ID="personname2"></SPAN>&nbsp;to edit family
					</TD>
				</TR>
				
				<TR><TD><IMG SRC="blankpixel.gif" WIDTH="1" HEIGHT="12"></TD></TR>
				
				<TR>
					<TD COLSPAN="2" CLASS="sboth">
						The email will include a link which allows&nbsp;<SPAN ID="personname3"></SPAN>&nbsp;to
						view, modify and share this family.					</TD>
				</TR>

				<TR><TD><IMG SRC="blankpixel.gif" WIDTH="1" HEIGHT="6"></TD></TR>
				
				<TR>
					<TD COLSPAN="2" CLASS="sboth">
						<INPUT TYPE="submit" NAME="sendemail" VALUE="Send Email" CLASS="sbutton2">
						&nbsp;
						<INPUT TYPE="submit" VALUE="Cancel" CLASS="sbutton2" onClick="parent.ESM('view'); return false;">
					</TD>
				</TR>

				<TR><TD><IMG SRC="blankpixel.gif" WIDTH="1" HEIGHT="12"></TD></TR>
			</TABLE>
			
			<TABLE WIDTH="100%" CELLSPACING=0 CELLPADDING=0 STYLE="border:solid #666666 1px; margin-top:12px;">
				<TR><TD><IMG SRC="blankpixel.gif" WIDTH="1" HEIGHT="12"></TD></TR>
				
				<TR>
					<TD CLASS="sboth">
						<B>Or copy the link and send it yourself:</B>
					</TD>
				</TR>

				<TR><TD><IMG SRC="blankpixel.gif" WIDTH="1" HEIGHT="12"></TD></TR>
				
				<TR>
					<TD CLASS="sboth">
						<INPUT ID="personlink" NAME="personlink" STYLE="width:240px;" VALUE="http://www.myfamilytree.com/?p=START&amp;c=xx2zyhhyzy&amp;f=434711346698725592" onFocus="this.select();" onSelect="this.select();" READONLY>
					</TD>
				</TR>

				<TR><TD><IMG SRC="blankpixel.gif" WIDTH="1" HEIGHT="6"></TD></TR>
				
				<TR>
					<TD COLSPAN="2" CLASS="sboth">
						<INPUT TYPE="submit" VALUE="Done" CLASS="sbutton" onClick="parent.ESM('view'); return false;">
					</TD>
				</TR>
				
				<TR><TD><IMG SRC="blankpixel.gif" WIDTH="1" HEIGHT="12"></TD></TR>
			</TABLE>
			<INPUT TYPE="hidden" NAME="sessionid" VALUE="888892243609317238">
			<INPUT TYPE="hidden" NAME="familyid" VALUE="434711346698725592">
			<INPUT TYPE="hidden" NAME="personid" VALUE="START">
			<INPUT TYPE="hidden" NAME="checksum" VALUE="xx2zyhhyzy">
			<INPUT TYPE="hidden" NAME="sharepersonid" VALUE="START">
		</FORM>

	</CENTER></BODY>

</HTML>
