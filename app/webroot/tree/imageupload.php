
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

		<script src="common.js?130317" type="text/javascript"></script>	

		<script type="text/javascript"><!--
			function start_upload()
			{
				SS('uploadbutton', false);
				SH('imagemessage', '<B>Please wait while uploading...</B>');
			}
			
			function remove_picture()
			{
				if (confirm('Are you sure you want to permanently remove the picture for this person?'))
					parent.SIF('434711346698725592', 'START', '', '', '');
			}
		--></script>
	</HEAD>
	<BODY>
		<FORM ENCTYPE="multipart/form-data" METHOD="POST" ACTION="imageupload.php?f=434711346698725592&p=START&c=xx2zyhhyzy&i=START&r="><TABLE WIDTH="100%" HEIGHT="100%"><TR VALIGN="middle"><TD ALIGN="center">

<SPAN ID="imagemessage">Upload photo, max size 8Mb:</SPAN>
			
			<BR>
			<INPUT NAME="file" TYPE="file" SIZE="1" STYLE="margin:12px;">
			<BR>
			<INPUT NAME="upload" ID="uploadbutton" TYPE="submit" VALUE="Upload" onClick="start_upload(); return true;">
		
			<INPUT TYPE="submit" VALUE="Cancel" onClick="parent.SIA(); return false;">
			
		</TD></TR></TABLE></FORM>
	</BODY>
</HTML>

