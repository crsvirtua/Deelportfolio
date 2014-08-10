<?php
    require_once("_include/queryManager.php");
    ini_set('session.gc_maxlifetime', 28800);
session_set_cookie_params(28800);
session_start();
if($_SESSION['loggedin']=='logged'){
    $auditID = $_GET['a'];
    $auditorID = $_GET['n'];
    $type = $_GET['t'];
    $getData = new queryManager;
    $audit = $getData->getAudit($auditID);
    $auditor = $getData->getAuditor($auditorID);
    $testID = $_POST["KenmerkID"];
 // print_r($_POST);
    
     
    //$indicator = $getData->getIndicatoren($auditID);
    $conclusie = $getData->getConclusions($auditID, $type);
    
    $notities = $getData->getNotes($auditID);
    //print_r($notities);
     //get all indicators:
    $kenmerknorm = $getData->getNorm($auditID);
    //print_r($kenmerknorm);
    $indicatoren = $getData->getAllNewIndicatoren();
    
   
  //  $kenmerken = $getData->getKenmerkenAudit($auditID);
    //get the indicators that are part of this Audit:
    $indicator = $getData->getNewIndicatoren($auditID);
   // $indicatorenScore = $getData->getIndicatorenScore($auditID, $type);
    //$indicatorenDev = $getData->getIndicatorenDev($auditID, $type);
   // $indicatorenCount = $getData->getIndicatorenCount($auditID, $type);
    //print_R($indicatorenScore);
    //put the indicators of this Audit in an array:
    
    $indicator = explode(",", $indicator[0]["AuditIndicatoren"]);
    //print_r($notities);
   // $samenvattingen = $getData->getKenmerkSamenvattingen($auditID);
   // print_r($indicator);
    
       $count=0;
    foreach($indicatoren as $value){
        
        if(in_array($value["Indicator_ID"], $indicator)){
              $indicatorenlijst[$count] = $value;
              $count++;
        }
    }
    $count = 0;
    foreach($indicatorenlijst as $value){
        $kenmerklijst[$count]["Kenmerk_ID"] = $value["Kenmerk_ID"];
        $kenmerklijst[$count]["Kenmerk"] = $value["Kenmerk"];
        $kenmerklijst[$count]["Norm"] = $value["Norm"];
        
        $count++;
    }
     $kenmerken = array_map("unserialize", array_unique(array_map("serialize", $kenmerklijst)));
     
     //print_R($indicatorenlijst);
     
    //Audit App Pilot - Audit Uitvoeren
    //$scores = $getData->getAuditScores($auditID, $indicatorID);
    if($_POST['XLS'] == 'Bekijk excel sheet') {
        header('Location: scoresToCSV.php?a='.$auditID.'');
    }
    elseif($_POST['Back'] == 'TERUG NAAR START') {
        header('Location: startAudit.php');
    }elseif($_POST['Switch'] == $type){
        if($type == 'Intern'){
              $_SESSION["type"] = "Extern";
           header('Location: overviewAudit.php?a='.$auditID.'&n='.$auditorID.'&t=Extern'); 
           
        }else{
              $_SESSION["type"] = "Intern";
          header('Location: overviewAudit.php?a='.$auditID.'&n='.$auditorID.'&t=Intern');  
        }
    }elseif($_POST['PDF'] == 'Bekijk intern rapport'){
        header('Location: PDF/createInternPDF.php?a='.$auditID.'');
    }elseif($_POST['PDF'] == 'Bekijk extern rapport'){
        header('Location: PDF/createExternPDF.php?a='.$auditID.'');
    }elseif($_POST["Conclusie"] == 'Opslaan'){
        if($_POST["Conclusietext"] == $conclusie[0]["Conclusie"]){}
        elseif (!empty($conclusie[0]["Conclusie"])){
            $conclusietext = $_POST["Conclusietext"];
           $conclusieobject = $getData->updateConclusion($auditID, $conclusietext, $type);
           
        }
        elseif(empty($conclusie[0]["Conclusie"])){
             $conclusietext = $_POST["Conclusietext"];
           $conclusieobject = $getData->setConclusion($auditID, $conclusietext, $type);
        }
             header('Location: overviewAudit.php?a='.$auditID.'&n='.$auditorID.'&t='.$type.'');
        }
        elseif($_POST["SamenvattingOpslaan"] == 'Opslaan'){
            
           for ($r = 1; $r <= 20; $r++) {
              
          if($_POST[$r.'&samenvatting'] == ''){$r+1;}
                        else{
                            
                            $samenvattingID= $r;
                            $samenvatting = $_POST[$r.'&samenvatting'];
                           // print_R($samenvatting);
                            $checksamenvatting = $getData->getKenmerkSamenvatting($auditID, $auditorID, $type);
                            
                            if(!empty($checksamenvatting[$r]["Samenvatting"])){
                              $getData->updateKenmerkSamenvatting($auditID, $auditorID, $samenvattingID, $samenvatting, $type);
                            }else{
                             $getData->setKenmerkSamenvatting($auditID, $auditorID, $samenvattingID, $samenvatting, $type);   
                            }
                            
                        
                $r+1;    
      }

            }
              header('Location: overviewAudit.php?a='.$auditID.'&n='.$auditorID.'&t='.$type.'');
        }
      
      
      
    
   
    
    
?>
<?php
 $bijlagen = $getData->getBijlage($auditID);
// check what browser the visitor is using
  $user_agent = $_SERVER['HTTP_USER_AGENT'];

// This bit differentiates IE from Opera
if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent))
    {
      print
        'This is Internet Explorer. (Insert joke here)';
    }
    elseif(preg_match('/mozilla/i',$u_agent) && !preg_match('/compatible/', $userAgent))
    {
      print
        'This is FireFox.';
    }
// let Chrome be recognized as Safari
    elseif(preg_match('/webkit/i',$u_agent))
    {
      print
        'This is either Chrome or Safari.';
    }
    elseif(preg_match('/Opera/i',$u_agent))
    {
      print
        'This is Opera. Like to live on the edge, huh?';
    }
    elseif(preg_match('/Netscape/i',$u_agent))
    {
      print
        'This is Netscape, and you really need to upgrade.';
    }
   
?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="_include/css/overviewAudit.css"/> 
        <!--[if IE]><link rel="stylesheet" type="text/css" href="_include/css/overviewAuditIE.css"/><![endif]--> 
        
        <title>Audit App Pilot - Audit uitvoeren</title>
        <script language="javascript"> 
            function toggle() {
                var ele = document.getElementById("selectExisting");
                var ele2 = document.getElementById("addNew");
                var ele3 = document.getElementById("contentright5");
                if(ele.style.display == "block") {
                    ele.style.display = "none";
                    ele2.style.display = "block";
                    ele3.style.display = "none";
                }
                else {
                    ele.style.display = "block";
                    ele2.style.display = "none";
                    ele3.style.display = "block";
                }
            } 
            function toggleOpmerking(divID) {
                var ele = document.getElementById(divID);
                var ele2 = document.getElementById('doorzichtig');
                var browserName=navigator.appName; 
                if(ele2.style.display == "block") {
                     ele2.style.display = "none";
                     document.getElementsByTagName("body")[0].style.overflow = "auto";
                }
                else {
                     document.getElementsByTagName("body")[0].style.overflow = "hidden";
                     if (browserName=="Microsoft Internet Explorer") { }
                     else {
                        ele2.style.height= document.documentElement.clientHeight+'px';
                     }
                     ele2.style.display = "block";
                }
                if(ele.style.display == "block") {
                    ele.style.display = "none";
                }
                else {
                    ele.style.display = "block";
                }
            }
            function toggleSamenvatting(divsmvID) {
                var elesmv = document.getElementById(divsmvID);
                var elesmv2 = document.getElementById('doorzichtig');
                var browserName=navigator.appName; 
                if(elesmv2.style.display == "block") {
                     elesmv2.style.display = "none";
                     document.getElementsByTagName("body")[0].style.overflow = "auto";
                }
                else {
                     document.getElementsByTagName("body")[0].style.overflow = "hidden";
                     if (browserName=="Microsoft Internet Explorer") { }
                     else {
                        elesmv2.style.height= document.documentElement.clientHeight+'px';
                     }
                     elesmv2.style.display = "block";
                }
                if(elesmv.style.display == "block") {
                    elesmv.style.display = "none";
                }
                else {
                    elesmv.style.display = "block";
                }
            }
              function toggleNotitie(divnotID) {
                var elenot = document.getElementById(divnotID);
                var elenot2 = document.getElementById('doorzichtig');
                var browserName=navigator.appName; 
                if(elenot2.style.display == "block") {
                     elenot2.style.display = "none";
                     document.getElementsByTagName("body")[0].style.overflow = "auto";
                }
                else {
                     document.getElementsByTagName("body")[0].style.overflow = "hidden";
                     if (browserName=="Microsoft Internet Explorer") { }
                     else {
                        elenot2.style.height= document.documentElement.clientHeight+'px';
                     }
                     elenot2.style.display = "block";
                }
                if(elenot.style.display == "block") {
                    elenot.style.display = "none";
                }
                else {
                    elenot.style.display = "block";
                }
            }
     
            // disable the ENTER key, a user can't submit the form by
            // presseing enter:
            function stopRKey(evt) {
                var evt = (evt) ? evt : ((event) ? event : null);
                var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
                if ((evt.keyCode == 13) && (node.type=="text"))  {return false;}
            }

            document.onkeypress = stopRKey; 
        </script>
    </head>
    <body id="body">
         <form action="" method="POST" enctype="multipart/form-data">
        <div id="doorzichtig" class="doorzichtig" style="display:none"></div>
        <div id="contentcontainer">
            <div id="pageTitle">
               AUDIT OVERZICHT
            </div>
            <div id="pageContent">
                <div id="auditInfo">
                    <?php $auditNameLength = strlen($audit[0]['AuditNaam']); ?>
                    <?php if($auditNameLength < '20') { ?>
                        <div class="auditInfoFieldLong"><?php echo $audit[0]['AuditNaam']; ?></div>
                    <?php } else { ?>
                        <div class="auditInfoFieldLong2"><?php echo $audit[0]['AuditNaam']; ?></div>
                    <?php } ?>
                    <div class="auditInfoField"><?php echo $auditor[0]['Naam']; ?></div>
                    <div class="auditInfoField"><?php echo $auditor[0]['Rol']; ?></div>
                    <div class="auditInfoFieldLast"><input name="Switch" type="submit" class="submitFormButtonSmall" value="<?php echo $type; ?>" style="cursor:pointer;"/></div>
                                                    
                                                <?php $divNotName = 'notitie'; ?>
                                                <?php $changeNotButton = 'changeNotButton'.$notities[0]['Notitie_ID']; ?>
                                                <?php if(!empty($notities[0]['Notitie'])) { ?>
                                                    <?php echo '<div id="'.$changeNotButton.'" class="submitButtonSmvOrange">'; ?>
                                                        <a href="javascript:toggleNotitie('<?php echo $divNotName; ?>');">NOTITIES</a>
                                                    <?php echo '</div>'; ?>
                                                <?php } else { ?>
                                                <?php } ?>
                                                    <?php echo '<div id="'.$divNotName.'" style="display:none" class="opmerkingContainer">'; ?>
                                                        <?php foreach($notities as $valuenot) { ?>
                                                            <?php if(!empty($valuenot['Notitie'])) { ?>
                                                                <div class="opmerkingField"><?php echo $valuenot['Notitie']; ?></div>
                                                            <?php } else { ?>
                                                            <?php } ?>
                                                        <?php } ?>
                                                        <div class="submitOpmerkingButton">
                                                            <a href="javascript:toggleNotitie('<?php echo $divNotName; ?>');">SLUITEN</a>
                                                        </div>
                                                    <?php echo '</div>'; ?>
                                                                
                </div>
               
                    <?php
                    $i=$indicatorenlijst[0]["Kenmerk_ID"];
                    $p=0;
                    if(empty($kenmerken)) {} else {
                        foreach($kenmerken as $value1) { 
                            
                            $kenmerk = $value1["Kenmerk_ID"];
                          
//$kenmerknorm = $getData->getNorm($kenmerk, $auditID);
                
                            $kensuperdata = $getData->PreventScoreRequestFloodKenmerkType($auditID, $kenmerk, $type);
                            //print_r($kensuperdata);
                          //  print_r ($kensuperdata);
                          //  $kenmerkavg = $getData->getAuditKenmerkScores($auditID, $value1['Kenmerk_ID']);
                           // $kenmerkcount = $getData->getAuditKenmerkScoresCount($auditID, $value1['Kenmerk_ID']); ?>
                            <div class="kenmerkContainer">
                                <div class="kenmerkHeader">
                                    KENMERK
                                </div>
                                <div class="kenmerkName">
                                    <?php echo $value1['Kenmerk']; ?>
                                </div>
                                <div class="kenmerkScore">
                                    <div class="kenmerkScoreTitle">GEM:</div>
                                    <div class="scoreBoxTotal"><?php echo $kensuperdata[0]["ROUND(AVG( score.Score ),2)"] ; ?></div>
                                    <div class="kenmerkScoreTitle">AANTAL:</div>
                                    <div class="scoreBoxTotal"><?php echo $kensuperdata[0]["(SELECT COUNT(DISTINCT score.Score) FROM score INNER JOIN indicatoren ON indicatoren.Indicator_ID = score.Indicator_ID INNER JOIN auditoren ON auditoren.Pers_ID = score.Auditor_ID INNER JOIN rol ON rol.Rol_ID = auditoren.Rol_ID WHERE score.Audit_ID = '$auditID' "] ; ?></div>
                                     <?php $divSmvName = 'samenvatting'.$value1["Kenmerk_ID"]; 
                                     
                                     $samenvatting = $getData->getKenmerkSamenvattingType($auditID, $value1["Kenmerk_ID"], $type); 
                                     ?>
                                                <?php $changeSmvButton = 'changeButton'.$samenvatting[0]['Kenmerk_ID']; ?>
                                                <?php ?>
                                                    <?php echo '<div id="'.$changeSmvButton.'" class="submitButtonSmvOrange">'; ?>
                                                        <a href="javascript:toggleSamenvatting('<?php echo $divSmvName; ?>');">SAMENVATTING</a>
                                                    <?php echo '</div>'; ?>
                                                <?php  ?>
                                                <?php  ?>
                                                    <?php echo '<div id="'.$divSmvName.'" style="display:none" class="opmerkingContainer">'; ?>
                                                        <?php  ?>
                                                            <?php if(!empty($samenvatting[0]['Samenvatting'])) { ?>
                                                                <textarea class="conclusionText" name="<?php echo $value1["Kenmerk_ID"]."&samenvatting";?>"><?php echo $samenvatting[0]['Naam'].": ".$samenvatting[0]['Samenvatting']; ?></textarea>
                                                            <?php } else {?> <textarea class="conclusionText" name="<?php echo $value1["Kenmerk_ID"]."&samenvatting";?>"></textarea>
                                                            <?php } ?>
                                                        <?php  ?>
                                                        <div class="submitOpmerkingButton">
                                                            <a href="javascript:toggleSamenvatting('<?php echo $divSmvName; ?>');">SLUITEN</a> <br>
                                                            
                                                            <input name="SamenvattingOpslaan" type="submit" class="submitConclusion" value="Opslaan" style="cursor:pointer;"/>
                                                        </div>
                                                    <?php echo '</div>'; ?>



                                  
                                </div><br/>
                                <div class="scoreHeader">
                                        <?php if($type== "Intern"){}else{?>
                                    <div class="scoreBoxHeader1">ZELF</div>
                                    <?php }?>
                                    <div class="scoreBoxHeader2">GEM.</div>
                                    <div class="scoreBoxHeader3">AANTAL</div>
                                    <div class="scoreBoxHeader4">SPREID.</div>
                                     <div class="scoreBoxHeader5">NORM</div>
                                </div>
                                <?php
                                foreach($indicatorenlijst as $value) {
                                  
                                    //$norm = $getData->getNorm($value['Kenmerk_ID']);
                                    //$scores = $getData->getAuditScores($auditID, $value["Indicator_ID"]);
                                    //$stddev = $getData->getAuditScoreSTDDEV($auditID, $value["Indicator_ID"]);
                                    //$count = $getData->getScoreCount($auditID, $value["Indicator_ID"]);
                                    // All Query Requests have been replaced by one to prevent database flooding
                                    $indicatorID = $value["Indicator_ID"];
                                    $kenmerkID = $value["Kenmerk_ID"];
                                                            //For each loop hapert wanneer de kenmerkID niet overeenkomt. -  Waarschijnlijk koppelt de variabele $i niet correct aan de kenmerk ID, door de mismatch
                                                            //Worden de indicatoren niet getoond.t mogelijke probleem is dat de $i++ doorblijft lopen en de kenmerkID daardoor verkeerd neergezet word- FIXEN
                                                            //
                                    foreach($kenmerknorm as $valuenorm){
                                        if($valuenorm["Kenmerk_ID"] == $kenmerkID){
                                            $Norm = $valuenorm["Norm"];
                                        }else{}
                                    }
                                   // echo "ind:'.$indicatorID.' ken:'.$kenmerkID'";
                                   
                                    if($type == "Intern"){
                                      
                                        $indsuperdata = $getData->PreventScoreRequestFloodIndicatorType($auditID, $indicatorID, $type);}
                                        elseif($type == "Extern"){
                                            $intern = "Intern";
                                            $indinterndata = $getData->getInternScores($auditID, $indicatorID, $intern);
                                            //print_r($indinterndata);
                                            $indsuperdata = $getData->PreventScoreRequestFloodIndicatorType($auditID, $indicatorID, $type);
                                            //print_R($indsuperdata);
                                            }
                                            
                                        
                                   // print_r($indsuperdata);
                                  
                                    if($value['Kenmerk_ID'] == $i) { ?>
                                        <div class="indicatorContainer">
                                            <div class="indicatorHeader">
                                                INDICATOR
                                            </div>
                                            <?php $stringLength = strlen($value['Indicator']); ?>
                                            <?php if($stringLength <= '65') { ?>
                                                <div class="indicatorName">
                                                    <?php echo $value['Indicator']; ?>
                                                </div>
                                            <?php }
                                            else { ?>
                                                <div class="indicatorName2">
                                                    <?php echo $value['Indicator']; ?>
                                                </div>
                                            <?php } ?>
                                            <div class="scoreContainer">
                                                <div class="scoreWrapper">
                                                   <?php if($type== "Intern"){}else{?>
                                                    <div class="scoreBox"><?php echo $indinterndata[0]["ROUND(AVG(score.Score),2)"];?></div>
                                                    <?php } $currentScore = $indsuperdata[0]["ROUND(AVG(score.Score),2)"]; 
                                                        $verschil = $Norm-$currentScore; 
                                                        if($currentScore == '') { ?>
                                                            <div class="scoreBox"><?php echo $currentScore; ?></div>
                                                    <?php } elseif($verschil >= -0.1 && $verschil <= 0.1) { ?>
                                                            <div class="scoreBoxOrange"><?php echo $currentScore; ?></div>
                                                        <?php } elseif($currentScore < $Norm) { ?>
                                                            <div class="scoreBoxRed"><?php echo $currentScore; ?></div>
                                                        <?php } else { ?>
                                                            <div class="scoreBoxGreen"><?php echo $currentScore; ?></div>
                                                        <?php } ?>
                                                    <div class="scoreBox"><?php echo $indsuperdata[0]["COUNT(DISTINCT score.Score)"]; ?></div>
                                                    <div class="scoreBox"><?php echo $indsuperdata[0]["ROUND(stddev(score.Score),2)"]; ?></div>
                                                    <div class="scoreBoxLast"><?php echo $Norm; ?></div>
                                                </div>
                                                <?php $opmerkingen = $getData->getIndicatorOpmerkingenType($auditID, $value["Indicator_ID"], $type); ?>
                                                <?php $divName = 'opmerking'.$value['Indicator_ID']; ?>
                                                <?php $changeButton = 'changeButton'.$value['Indicator_ID']; ?>
                                                <?php if(!empty($opmerkingen[0]['Toelichting'])) { ?>
                                                    <?php echo '<div id="'.$changeButton.'" class="submitButtonOrange">'; ?>
                                                        <a href="javascript:toggleOpmerking('<?php echo $divName; ?>');">OPMERKINGEN</a>
                                                    <?php echo '</div>'; ?>
                                                <?php } else { ?>
                                                <?php } ?>
                                                    <?php echo '<div id="'.$divName.'" style="display:none" class="opmerkingContainer">'; ?>
                                                        <?php foreach($opmerkingen as $value4) { ?>
                                                            <?php if(!empty($value4['Toelichting'])) { ?>
                                                                <div class="opmerkingField"><?php echo $value4['Naam'].": ".$value4['Toelichting']; ?></div>
                                                            <?php } else { ?>
                                                            <?php } ?>
                                                        <?php } ?>
                                                        <div class="submitOpmerkingButton">
                                                            <a href="javascript:toggleOpmerking('<?php echo $divName; ?>');">SLUITEN</a>
                                                        </div>
                                                    <?php echo '</div>'; ?>
                                            </div>
                                        </div>
                                    <?php $p++;
                                    }
                                } ?>
                            </div>
                    <?php $i++;} }?>
                    <div id="bijlage"><br/>
                        <center>Conclusie:</center>
                        
                     
                           
                        <div id="conclusion">
                           <?php 
                           if(!empty($conclusie[0]["Conclusie"])){
                           foreach($conclusie as $value){
                              
                               echo'<div id="concText">'.$value["Conclusie"].'</div>';
                           }
                           } else{
                           }
                           ?> 
                           
                            <br />
                           
                            
                            
                         <textarea class="conclusionText" name="Conclusietext"><?php echo $conclusie[0]["Conclusie"]; ?></textarea>
                         <input name="Conclusie" type="submit" class="submitConclusion" value="Opslaan" style="cursor:pointer;"/>
                        </div>
                   
                    </div>
                    <div id="bottomLeft">
                          <input name="Back" type="submit" class="submitFormButtonLarge" value="TERUG NAAR START" style="cursor:pointer;"/>
                    </div>
                    <div id="bottomRight">
                         <input name="XLS" type="submit" class="submitFormButtonLarge" value="Bekijk excel sheet" style="cursor:pointer;"/> 
                         
                    </div>
                     <div id="bottomLeft">
                          <input name="PDF" type="submit" class="submitFormButtonLarge" value="Bekijk intern rapport" style="cursor:pointer;"/>
                    </div>
                    <div id="bottomRight">
                          <input name="PDF" type="submit" class="submitFormButtonLarge" value="Bekijk extern rapport" style="cursor:pointer;"/>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>
<?php  }else{ 
$_SESSION['notloggedin'] = 'loggedout'; 
header("Location: index.php");
}?>