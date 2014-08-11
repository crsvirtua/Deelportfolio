<?php
ini_set('upload_tmp_dir','/var/tmp/'); 
global $_FILES; 
	include ("Variabelen.php");
	include ("Mysql_functions.php");

		
	Function fnUploaden($strTempNaam, $strNaam){
		move_uploaded_file($strTempNaam, $strNaam);
	}
	
	function fnCheckRegel($arrVergelijken, $arrGegevens) {
		$blnGoed = "Ja"; 
		foreach ($arrVergelijken as $Sleutel => $Waarde) {
			if($arrGegevens[$Sleutel] == "") { $blnGoed = "Nee"; }
		}
		return $blnGoed;
	}
	
	function fnWisSpaties($strTekst) {
		$strNweTekst = preg_replace('/\s+/', '', $strTekst);
		return $strNweTekst; 
	}

//foreach ($_FILES['strBestand'] as $key => $ssss)
//	{
//	echo ("Sleutel $key bevat $ssss<br>");
//		if(is_array($ssss)) {
//			foreach ($_FILES[$key] as $keySub => $ssssSub)
//				{
//				echo ("&nbsp;&nbsp;&nbsp;&nbsp;SubSleutel $keySub bevat $ssssSub<br>");
//				}
//		}
//}

echo "Error:".$_FILES['strBestand']['error']; 
if ($_POST["strActie"] == "Add") {
	echo "Hierr: <br />"; 
	$arrExtensies=array("csv", "xls");

		// Bestand uploaden
			$strTempNaam = $_FILES['strBestand']['tmp_name'];
			list($Naam,$Extensie) = explode(".",$strTempNaam);
			$strNaam = "Erich";
			$strBestandNaam = $strNaam.".csv";
			$strDoelDir=realpath('./../../UpdateData/');
			echo "Doel: ".realpath('./../../UpdateData/')."<br />"; 
			$strNaam = $strDoelDir."/".$strBestandNaam;
			echo "TempNaam: ".$strTempNaam."<br />"; 
			echo "Naam: ".$strNaam."<br />"; 

			//Uploaden orgineel

//echo "<pre>";
//echo "POST:";
//print_r($_POST);
//echo "FILES:";
//print_r($_FILES);
//echo "</pre>";
			fnUploaden($strTempNaam,$strNaam);

	//Echo "Verwerken data in database
	$Connection_Id=Make_Connection();
	Select_Database(Hoofd_Db);
	
	//Tabel waarin de gegevens geplaatst moeten worden
	$strTabel = "Profile_Growth"; 
		
	$row = 1;
	$blnLabel = "Ja";	//Er zit een labelregel in het bestand
	$arrVeldNummer = array(1, 2, 3, 4, 5, 6, 7, 8, 10, 13);
	
	//Zet verwerkingstijd op 10 minuten
	set_time_limit(600);
	$intI = 0;
	$intNietCompleet = 0;
	//Loop om csv bestand in te lezen.
	if (($handle = fopen($strNaam, "r")) !== FALSE) {
	    while (($data = fgetcsv($handle, 4000, ";")) !== FALSE) {
			//Kop van het bestand
			//"DatumExport";"BrinVest";"EsisIdentificatienummer";"Vormingsgebied";"Toets";"Toetsversie";"Schooljaar";"Afnamedatum";"Leerjaar";"Afnamemoment";"DL";"Ruwescore";"Vaardigheidsscore";"DLE";"AE";"IV";"Norm"
	
			if (($row == 1 && $blnLabel == "Nee") || ($row != 1)) {
				//Omzetten datum naar engelse notatie
				$arrDatum = explode("-", $data[7]);
				$intDatum = mktime(0, 0, 0, $arrDatum[1], $arrDatum[0], $arrDatum[2]);
				$ExcelDatum = (int)(25570 + ($intDatum / 86400));		//Was (int)(25569 + ($intDatum / 86400)) 25569 is aantaldagen tussen 1 January 1900 and 1 January 1970;	
				$Verschil = $ExcelDatum - $data[17];
//				echo $data[7]." is gelijk aan: ".$data[17]. " en wordt in PHP exceldatum: ".$ExcelDatum." Verschil: ".$Verschil."<br />";
				$data[7] = $arrDatum[2]."/".$arrDatum[1]."/".$arrDatum[0];
				//Controles

				//Controler of velden gevuld zijn. 
				$blnCompleet = fnCheckRegel($arrVeldNummer, $data); 
//				echo $row." is compleet: ".$blnCompleet."<br />";
				if($blnCompleet == "Ja") {
					// Zo ja, dan verder, zo nee, dan record overslaan
					// maak primaire sleutel door velden te koppelen 4 pos van $data[1]+ $data[2] + $data[4] + $data[5] + $data[7] als getal vanaf 1900
					$intDatum = mktime(0, 0, 0, $arrDatum[1], $arrDatum[0], $arrDatum[2]);
					$RecordKey = substr(fnWisSpaties($data[1]), 0,4).fnWisSpaties($data[2]).fnWisSpaties($data[4]).fnWisSpaties($data[5]).$ExcelDatum;
		
					// Check of record reeds is ingelezen
					$strSQL = "SELECT ESIS_LVS_UniekToetsID FROM ".$strTabel." WHERE ESIS_LVS_UniekToetsID='".$RecordKey."'";
//	echo $strSQL."<br />";
					$rst=Run_Selection($Connection_Id, $strSQL);
					if(mysql_num_rows($rst) == 0) {
						// Niet ingelezen, schrijf dan weg: sleutel, $data[2], $data[1], $data[7], $data[3], $data[6], $data[8], $data[10], $data[13] 
						$strSQL = "INSERT INTO ".$strTabel." (ESIS_LVS_UniekToetsID, studentID_ESIS, Brin, testDate, testType, schoolYear, gradeYear, DL, DLE) "; 
						$strSQL.= "VALUES ('".$RecordKey."', '".substr(fnWisSpaties($data[1]), 0,4).$data[2]."', '".$data[1]."', '".$data[7]."', '".$data[3]."', '".$data[6]."', '".$data[8]."', '".$data[10]."', '".$data[13]."')"; 
						$rst=Run_Selection($Connection_Id, $strSQL);
					} else {
						$intI = $intI + 1;
					}
				} else {
					$intNietCompleet = $intNietCompleet + 1; 
				}
			}
	        $row++;
	    }
	    fclose($handle);
	}
}
echo "Aantal niet compleet: ".$intNietCompleet."<br />";
echo "Aantal niet ingelzen: ".$intI."<br />";

//header("Location: Upload.html");
?> 