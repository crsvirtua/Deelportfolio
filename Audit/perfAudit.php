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
    
    //$type = $_GET['t'];
    $datum = $getData->getDatum($auditID, $auditorID);
    $audit = $getData->getAudit($auditID);
    $auditor = $getData->getAuditor($auditorID);
    //$type = "Extern";
    //get all indicators:
    $indicatoren = $getData->getAllNewIndicatoren();

    //get the indicators that are part of this Audit:
    $indicator = $getData->getNewIndicatoren($auditID);
   
    //put the indicators of this Audit in an array:
    $indicator = explode(",", $indicator[0]["AuditIndicatoren"]);
    $auditnotitie = $getData->getNotitie($auditID, $auditorID);
    if($auditnotitie[0]['Notitie_ID'] == '') {
        $auditnotitie[0]['Notitie_ID'] = '0';
    }
    
    $q=0;
    

    //check if indicator is part of the Audit and delete if not:
  
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

        
        $count++;
    }
    //print_R($indicatorenlijst);
    //print_r($indicator);
    $kenmerken = array_map("unserialize", array_unique(array_map("serialize", $kenmerklijst)));
   
    if(empty($auditID)|| empty($auditorID)){
       header('Location: startAudit.php');
  }
    if($_POST['uploadData'] == 'OPSLAAN EN OVERZICHT') {
        $headerLoc = 'opslaanOverzicht';
    }
    elseif($_POST['uploadData'] == 'OPSLAAN EN LATER HERVATTEN') {
        $headerLoc = 'opslaanHervatten';
    }elseif($_POST['uploadData'] == 'TUSSENDOOR OPSLAAN') {

        $headerLoc = 'opslaanDoorgaan';
    }elseif($_POST['uploadData'] == 'BIJLAGEN'){
        $headerLoc = 'bijlagen';
    }elseif($_POST['Switch'] == $type){
        if($type == 'Intern'){
           header('Location: perfAudit.php?a='.$auditID.'&n='.$auditorID.'&t=Extern'); 
           $_SESSION["type"] = "Extern";
        }else{
          header('Location: perfAudit.php?a='.$auditID.'&n='.$auditorID.'&t=Intern'); 
          $_SESSION["type"] = "Intern";
        }
    }
    $y=$indicatorenlijst[0]["Indicator_ID"];

    $p=0;
    $o=0;
    $m=0;
    $r=0;
    if($auditID== '5'){
        $r=10;
    }
    elseif($auditID== '6'){
        $r=10;
    }
    elseif($auditID== '7'){
        $r=11;
    }
    else{$r=0;}
    

    $bestaandeScores = $getData->getIndicatorIDs($auditID, $auditorID, $type);
//print_r($bestaandeScores);
    if(!empty($bestaandeScores)) {
        foreach($bestaandeScores as $value) {
            $exScoresArray[$m] = $value['Indicator_ID'];
            $m++;
        }
    }

   unset($_POST['uploadData']);

    if(!empty($_POST)) {
        foreach($_POST as $key=>$value) {  
            //if the post is a notitie:
            if($key == $auditnotitie[0]['Notitie_ID'].'&id_notitie') {
                $notitie = $value;
            }
            //if the post is something else (score, opmerking):
            else {
                if(!empty($exScoresArray)) {
                    if(in_array($y, $exScoresArray)) {
                        if($_POST[$r.'&samenvatting'] == ''){}
                        else{
                            $samenvattingArray[$p]["Kenmerk_ID"] = $r;
                            $samenvattingArray[$p]['Samenvatting'] = $_POST[$r.'&samenvatting'];
                        }
                        if($_POST[$y.'&score'] == '') {}
                        else {
                            $updateScoreArray[$p]['indicator'] = $y;
                            $updateScoreArray[$p]['score'] = $_POST[$y.'&score'];
                        }
                        if($_POST[$y.'&toelichting'] == '') {}
                        else {
                            $updateToelichtingArray[$p]['indicator'] = $y;
                            $updateToelichtingArray[$p]['toelichting'] = $_POST[$y.'&toelichting'];
                        }
                    }
                    else {
                        if($_POST[$y.'&score'] == '' && $_POST[$y.'&toelichting'] == '') {}
                        else {
                            $uploadArray[$p]['indicator'] = $y;
                            $uploadArray[$p]['score'] = $_POST[$y.'&score'];
                            $uploadArray[$p]['toelichting'] = $_POST[$y.'&toelichting'];
                        }
                        if($_POST[$r.'&samenvatting'] == ''){}
                        else{
                            $samenvattingArray[$p]["Kenmerk_ID"] = $r;
                            $samenvattingArray[$p]['Samenvatting'] = $_POST[$r.'&samenvatting'];
                        }
                    }
                    $p++;
                }
                else {
                    if($_POST[$y.'&score'] == '' && $_POST[$y.'&toelichting'] == '') {}
                    else {
                        $uploadArray[$p]['indicator'] = $y;
                        $uploadArray[$p]['score'] = $_POST[$y.'&score'];
                        $uploadArray[$p]['toelichting'] = $_POST[$y.'&toelichting'];
                    }
                    if($_POST[$r.'&samenvatting'] == ''){}
                    else{
                        $samenvattingArray[$p]["Kenmerk_ID"] = $r;
                        $samenvattingArray[$p]['Samenvatting'] = $_POST[$r.'&samenvatting'];
                    }
                    $p++;
                }
                $y++;
                $r++;
            }
        }
    }

    if(!empty($updateScoreArray)) {
        foreach($updateScoreArray as $value) {
            $updateData = $getData->updateScore($auditID, $auditorID, $value['indicator'], $value['score'], $type);
        }
        if(!empty($datum[0]["DatumAfname"])){}
        else{
            $date = date("j-m-y"); 
            $dateupload = $getData->setDatum($auditID, $auditorID, $date);
        }
    }
    if(!empty($updateToelichtingArray)) {
        foreach($updateToelichtingArray as $value) {
            $updateData = $getData->updateToelichting($auditID, $auditorID, $value['indicator'], $value['toelichting'], $type);
        }
    }
    if(!empty($uploadArray)) {
        foreach($uploadArray as $value) {
            $uploadData = $getData->setScoreToelichting($auditID, $auditorID, $value['indicator'], $value['score'], $value['toelichting'], $type);
        }
    }

    if(!empty($notitie)) {
        if($auditnotitie[0]["Notitie"] == ''){
             $notitie = $getData->setNotitie($auditID, $auditorID, $notitie);
        }else{
           $notitie = $getData->updateNotitie($auditID, $auditorID, $notitie);   
        }
    }
    else{ }
    
    
    $l=0;

 
            
    if($headerLoc == 'opslaanOverzicht') {
       header('Location: overviewAudit.php?a='.$auditID.'&n='.$auditorID.'&t='.$type);
    }
    elseif($headerLoc == 'opslaanHervatten') {
        header('Location: startAudit.php?a=1&n=6');
    }elseif($headerLoc == 'opslaanDoorgaan') {
       header('Location: perfAudit.php?a='.$auditID.'&n='.$auditorID.'&t='.$type);
    }elseif($headerLoc == 'bijlagen'){
        header('Location: attachAudit.php?a='.$auditID.'&n='.$auditorID.'&t='.$type.'');
    }
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="_include/css/perfAudit.css"/>
        <!--[if IE]><link rel="stylesheet" type="text/css" href="_include/css/perfAuditIE.css"/><![endif]--> 
        <title>Audit App Pilot - Audit Uitvoeren</title>
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
                
                if(ele.style.display == "block") {
                    ele.style.display = "none";
                }
                else {
                    ele.style.display = "block";
                }
            }
            function toggleOpmerkingOpslaan(divID, buttonID) {
                var ele = document.getElementById(divID);
                var ele2 = document.getElementById(buttonID);
                if(ele.style.display == "block") {
                    ele.style.display = "none";
                }
                else {
                    ele.style.display = "block";
                }
                ele2.setAttribute("class", "submitButtonGreen");
                ele2.setAttribute("className", "submitButtonGreen");
            }
            function toggleNotitie(divNotID) {
                var elenot = document.getElementById(divNotID);
                
                if(elenot.style.display == "block") {
                    elenot.style.display = "none";
                }
                else {
                    elenot.style.display = "block";
                }
            }
            function toggleNotitieOpslaan(divNotID, buttonNotID) {
                var elenot = document.getElementById(divNotID);
                var elenot2 = document.getElementById(buttonNotID);
                if(elenot.style.display == "block") {
                    elenot.style.display = "none";
                }
                else {
                    elenot.style.display = "block";
                }
                elenot2.setAttribute("class", "submitButtonGreen");
                elenot2.setAttribute("className", "submitButtonGreen");
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
        <div id="contentcontainer">
            <div id="pageTitle">
                AUDIT UITVOEREN
            </div>
            <div id="pageContent">
                <form action="" method="POST">
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
                        
                        <?php $divNameNot = 'notitie1'.$auditID; ?>
                                                <?php $changeButton = 'changeButton1'.$auditID ?>
                                                <?php if(!empty($auditnotitie[0]['Notitie'])) { ?>
                                                    <?php echo '<div id="'.$changeButton.'" class="submitButtonOrange">'; ?>
                                                        <a href="javascript:toggleNotitie('<?php echo $divNameNot; ?>');">NOTITIE</a>
                                                    <?php echo '</div>'; ?>
                                                <?php } else { ?>
                                                    <?php echo '<div id="'.$changeButton.'" class="submitButton">'; ?>
                                                        <a href="javascript:toggleNotitie('<?php echo $divNameNot; ?>');">NOTITIE</a>
                                                    <?php echo '</div>'; ?>
                                                <?php } ?>
                                                <?php echo '<div id="'.$divNameNot.'" style="display:none" class="opmerkingContainer">'; ?>
                                                    <?php if(!empty($auditnotitie[0]['Notitie'])) { ?>
                                                        <textarea class="opmerkingField" name="<?php echo $auditnotitie[0]['Notitie_ID'].'&id_notitie'; ?>" ><?php echo $auditnotitie[0]['Notitie']; ?></textarea>
                                                    <?php } else { ?>
                                                        <textarea class="opmerkingField" name="<?php echo $auditnotitie[0]['Notitie_ID'].'&id_notitie'; ?>"></textarea>
                                                    <?php } ?>
                                                    <div class="submitOpmerkingButton">
                                                        <a href="javascript:toggleNotitie('<?php echo $divNameNot; ?>');">ANNULEREN</a>
                                                    </div>
                                                    <div class="submitOpmerkingButton">
                                                        <a href="javascript:toggleNotitieOpslaan('<?php echo $divNameNot; ?>', '<?php echo $changeButton; ?>');">OPSLAAN</a>
                                                    </div>
                                                <?php echo '</div>'; ?>
                </div>
          
                    <?php
                    $i=$indicatorenlijst[0]["Kenmerk_ID"];
                    $kenmerkcount = $i -1;
                    $p=0;
                   // print_r($indicator);
                    
                    if(empty($kenmerken)) {} else {
                        foreach($kenmerken as $value1) { ?>
                            <div class="kenmerkContainer">
                                <div class="kenmerkHeader">
                                    KENMERK
                                </div>
                                <div class="kenmerkName">
                                    <?php echo $value1['Kenmerk']; ?>
                                </div>
                                <?php
                              
                                foreach($indicatorenlijst as $value) {
                                    $score = $getData->getScore($auditID, $auditorID, $value['Indicator_ID'], $type);
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
                                                <div class="radioContainer">
                                                    <div class="radioLabel">
                                                        1
                                                    </div>
                                                    <div class="radioButton">
                                                        <input class="radio" type="radio" name="<?php echo $value['Indicator_ID'].'&score'; ?>" value="1"  <?php if($score[0]['Score'] == 1) { echo "CHECKED"; }?>/>
                                                    </div>
                                                </div>
                                                <div class="radioContainer">
                                                    <div class="radioLabel">
                                                        2
                                                    </div>
                                                    <div class="radioButton">
                                                        <input class="radio" type="radio" name="<?php echo $value['Indicator_ID'].'&score'; ?>" value="2"  <?php if($score[0]['Score'] == 2) { echo "CHECKED"; }?>/>
                                                    </div>
                                                </div>
                                                <div class="radioContainer">
                                                    <div class="radioLabel">
                                                        3
                                                    </div>
                                                    <div class="radioButton">
                                                        <input class="radio" type="radio" name="<?php echo $value['Indicator_ID'].'&score'; ?>" value="3"  <?php if($score[0]['Score'] == 3) { echo "CHECKED"; }?>/>
                                                    </div>
                                                </div>
                                                <div class="radioContainer">
                                                    <div class="radioLabel">
                                                        4
                                                    </div>
                                                    <div class="radioButton">
                                                        <input class="radio" type="radio" name="<?php echo $value['Indicator_ID'].'&score'; ?>" value="4"  <?php if($score[0]['Score'] == 4) { echo "CHECKED"; }?>/>
                                                    </div>
                                                </div>
                                                <div class="radioContainer">
                                                    <div class="radioLabel">
                                                        5
                                                    </div>
                                                    <div class="radioButton">
                                                        <input class="radio" type="radio" name="<?php echo $value['Indicator_ID'].'&score'; ?>" value="5"  <?php if($score[0]['Score'] == 5) { echo "CHECKED"; }?>/>
                                                    </div>
                                                </div>
                                                <div class="radioContainer">
                                                    <div class="radioLabel">
                                                        -
                                                    </div>
                                                    <div class="radioButton">
                                                        <input class="radio" type="radio" name="<?php echo $value['Indicator_ID'].'&score'; ?>" value=""  <?php if($score[0]['Score'] == "") { echo "CHECKED"; }?>/>
                                                    </div>
                                                </div>
                                                <?php $divName = 'opmerking'.$value['Indicator_ID']; ?>
                                                <?php $changeButton = 'changeButton'.$value['Indicator_ID']; ?>
                                                <?php if(!empty($score[0]['Toelichting'])) { ?>
                                                    <?php echo '<div id="'.$changeButton.'" class="submitButtonOrange">'; ?>
                                                        <a href="javascript:toggleOpmerking('<?php echo $divName; ?>');">OPMERKING</a>
                                                    <?php echo '</div>'; ?>
                                                <?php } else { ?>
                                                    <?php echo '<div id="'.$changeButton.'" class="submitButton">'; ?>
                                                        <a href="javascript:toggleOpmerking('<?php echo $divName; ?>');">OPMERKING</a>
                                                    <?php echo '</div>'; ?>
                                                <?php } ?>
                                                <?php echo '<div id="'.$divName.'" style="display:none" class="opmerkingContainer">'; ?>
                                                    <?php if(!empty($score[0]['Toelichting'])) { ?>
                                                        <textarea class="opmerkingField" name="<?php echo $value['Indicator_ID'].'&toelichting'; ?>" ><?php echo $score[0]['Toelichting']; ?></textarea>
                                                    <?php } else { ?>
                                                        <textarea class="opmerkingField" name="<?php echo $value['Indicator_ID'].'&toelichting'; ?>"></textarea>
                                                    <?php } ?>
                                                    <div class="submitOpmerkingButton">
                                                        <a href="javascript:toggleOpmerking('<?php echo $divName; ?>');">ANNULEREN</a>
                                                    </div>
                                                    <div class="submitOpmerkingButton">
                                                        <a href="javascript:toggleOpmerkingOpslaan('<?php echo $divName; ?>', '<?php echo $changeButton; ?>');">OPSLAAN</a>
                                                    </div>
                                                <?php echo '</div>'; ?>
                                            </div>
                                        </div>
                                    <?php $p++;
                                    }
                                }  
                                ?>
                               
                                
                                
                            </div>
                        <?php $kenmerkcount++; $i++;} }?>
                    <div id="bottomLeft">
                        <input name="uploadData" type="submit" class="submitFormButtonLarge" value="OPSLAAN EN LATER HERVATTEN" style="cursor:pointer;"/>
                      
                    </div>
                    <div id="bottomright">
                        <input name="uploadData" type="submit" class="submitFormButtonLarge" value="OPSLAAN EN OVERZICHT" style="cursor:pointer;"/>
                    </div> <div id="bottomLeft">  <input name="uploadData" type="submit" class="submitFormButtonLarge" value="TUSSENDOOR OPSLAAN" style="cursor:pointer;"/>
                     </div> 
                    <div id="bottomright">
                        <input name="uploadData" type="submit" class="submitFormButtonLarge" value="BIJLAGEN" style="cursor:pointer;"/>
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