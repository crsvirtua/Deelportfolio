<?php
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="content-type" content="text/html;charset=iso-8859-1"/>
	<meta http-equiv="Content-Style-Type" content="text/css" />		
	<title>Uploaden bestand</title>
</head>
<body leftmargin="0" topmargin="0">
		<form id="frmMutatie" name="frmMutatie" enctype="multipart/form-data" method="post" action="Upload.php">
			<input type="hidden" id="strActie" name="strActie" value="Add"/>
			<table cellspacing="0" cellpadding="0" border="0" width="100%">
				<tr><td width="10px"></td><td colspan="2">&nbsp;</td><td width="10px"></td></tr>
<!--				<tr><td width="10px"></td><td width="150px">Soort bestuur:</td>
					<td>
						<input type="radio" name="strBestuur" value="A" id="strBestuur" selected='selected'>BCOO&nbsp;
						<input type="radio" name="strBestuur" value="S" id="strBestuur">SKOF&nbsp;
						<input type="radio" name="strBestuur" value="P" id="strBestuur">Prisma&nbsp;
						<input type="radio" name="strBestuur" value="X" id="strBestuur">Anders 
					</td>
					<td width="10px"></td></tr>
-->				<tr><td width="10px"></td><td width="150px">Bestand:</td>
					<td><input id="strBestand" name="strBestand" type="file" size="40"/></td>
					<td width="10px"></td></tr>
<tr><td width="10px"></td><td colspan="2">&nbsp;</td><td width="10px"></td></tr>
				<tr><td width="10px"></td><td colspan="2">Gemaakte aanpassingen: </td><td width="10px"></td></tr>
				<tr><td width="10px"></td><td colspan="2">Pas bestand variabelen.php aan aan eigen situatie.. </td><td width="10px"></td></tr>

				<tr><td width="10px"></td><td colspan="2">upload_max_filesize in PHP.ini moet ruim genoeg zijn bij grote bestanden: bv 7m</td><td width="10px"></td></tr>
				<tr><td width="10px"></td><td colspan="2">Veldlengte van ESIS_LVS_UniekToetsID verruimd naar 100</td><td width="10px"></td></tr>
				<tr><td width="10px"></td><td colspan="2">Open tijdelijk het te importeren bestand in Excel en maak aan het einde een kolom met daarin de exceldatum als getal. Dit om te controleren of e.a. goed uitgerekend wordt door PHP</td><td width="10px"></td></tr>
<!--				<tr><td width="10px"></td><td colspan="2">Primiary key eraf gehaald i.v.m. dubbele records...</td><td width="10px"></td></tr>
				<tr><td width="10px"></td><td colspan="2">Schooljaar en leerjaar mogen null zijn of worden omgezet naar 0...</td><td width="10px"></td></tr>
				<tr><td width="10px"></td><td colspan="2">Vled type leerjaar omgezet naar varchar(3) i.v..m waarde S...</td><td width="10px"></td></tr>
-->				<tr><td width="10px"></td><td colspan="2">
					<input type="submit" id="btnSubmit" name="btnSubmit" value="Inlezen" >
					</td><td width="10px"></td>
				</tr>
			</table>
		</form>
</body>
</html>
