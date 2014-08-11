<?php 
    $auditID = $_GET['audit'];

    $URL = "http://testomgeving.webfloris.nl/editAudit.php";
    session_start(); 
    require_once("_include/queryManager.php"); 
    $getData = new queryManager;
    $error = '';
    $auditinfo = $getData->getAuditInfo($auditID);
    $indicatoren1 = $getData->getAllNewIndicatoren();
    $kenmerken = $getData->getAllKenmerken();
    $kenmerkenAudit = $getData->getKenmerkenAudit($auditID);
    $i=0;
    if(!empty($kenmerkenAudit)) {
        foreach($kenmerkenAudit as $value) {
            $kenmerkenAuditSimple[$i] = $kenmerkenAudit[$i]['Kenmerk'];
            $i++;
        }
    }

    $auditIndicatoren = $auditinfo[0]['AuditIndicatoren'];
    $auditIndicatoren = explode(",", $auditIndicatoren);
    if(isset($_POST['selectAudit'])) {
        header("Location:editAudit.php?audit=".$_POST['audit']);
    }
    if(isset($_POST['backToStart'])) {
        header("Location: adminAudit.php");
    }
    if(isset($_POST['backToAudit'])) {
        header("Location: editAudit.php?audit=".$auditID);
    }
    if(isset($_POST['saveAudit'])) {
        unset($_POST['saveAudit']);
        $auditNaam = $_POST['auditName'];
        $auditSchool = $_POST['auditSchool'];
        $auditDoel = $_POST['auditGoal'];
        unset($_POST['auditName']);
        unset($_POST['auditSchool']);
        unset($_POST['auditGoal']);
        
        if(!empty($auditNaam)) {
            $uploadAudit = $getData->updateNaam($auditNaam);
        }
        if(!empty($auditSchool)) {
            $uploadAudit = $getData->updateSchool($auditSchool);
        }
        if(!empty($auditDoel)) {
            $uploadAudit = $getData->updateDoel($auditDoel);
        }
        
        $bestaandeNormen = $getData->getNormen($auditID);
        $i=0;
        if(!empty($bestaandeNormen)) {
            foreach($bestaandeNormen as $value) {
                $bestaandeNorm['ID'][$i] = $value['Kenmerk_ID'];
                $bestaandeNorm['Norm'][$i] = $value['Norm'];
                $i++;
            }
        }
        $i=0;
        foreach($_POST as $key => $value) {
            $key = explode("&", $key);
            $kenmerk[$i]['ID'] = $key[0];
            $kenmerk[$i]['NORM'] = $value;
            $i++;
        }
        if(!empty($kenmerk)) {
            foreach($kenmerk as $value) {
                if(in_array($value['ID'], $bestaandeNorm['ID'])) {
                    //update the normen
                    $update = $getData->updateNorm($auditID, $value['ID'], $value['NORM']);
                }
                else {
                    //insert the normen
                    $insert = $getData->saveNormen($auditID, $value['ID'], $value['NORM']);
                }
                header("Location:".$URL);
            }
        }
    }
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="_include/css/backendCSS.css"/> 
        <title>Audit App Pilot - Audit Aanpassen</title>
        <script language="javascript"> 
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
                AUDIT AANMAKEN
            </div>
            <div id="pageContent">
                <?php 
                //if there is an error, display it:
                    if(!empty($error)) { ?>
                    <br/>
                    <div id="pageError"><img src="_include/images/error_1.jpg" alt=""/><?php echo $error; ?></div>
                    
                <?php } 
                ?> <form action="" method="POST">  <?php
                    if(empty($auditID) && !isset($_POST['selectAudit'])) {
                        echo "Kies een audit:";
                        ?>
                        <select name="audit" class="opmerkingfield">
                            <?php
                            
                            $audits = $getData->getAudits();
                            foreach($audits as $value) {
                                echo "<option value='".$value['Audit_ID']."'>".$value['AuditNaam']."</option>";
                            }
                            ?>
                        </select>
                        <input name="selectAudit" type="submit" class="submitFormButtonAuto" value="PAS AUDIT AAN" style="cursor:pointer;"/>
                        <input name="backToStart" type="submit" class="submitFormButtonAuto" value="TERUG NAAR OVERZICHT " style="cursor:pointer;"/>
                        <?php
                    }
                    elseif(isset($_POST['addDelKenmerk'])) {
                        foreach($kenmerken as $value) {
                            if(!empty($kenmerkenAuditSimple)) {
                                if(in_array($value['Kenmerk'], $kenmerkenAuditSimple)) {
                                    echo "<div class='kenmerkwrap'>
                                            <div class='kenmerkselect'>
                                                <input type='checkbox' CHECKED name='".$value['Kenmerk_ID']."' value='".$value['Kenmerk_ID']."'>
                                            </div>
                                            <div class='kenmerknaam'>"
                                                .$value['Kenmerk'].
                                            "</div>
                                        </div>";
                                }
                                else {
                                    echo "<div class='kenmerkwrap'>
                                            <div class='kenmerkselect'>
                                                <input type='checkbox' name='".$value['Kenmerk_ID']."' value='".$value['Kenmerk_ID']."'>
                                            </div>
                                            <div class='kenmerknaam'>"
                                                .$value['Kenmerk'].
                                            "</div>
                                        </div>";
                                }
                            }
                        }
                        ?>
                        <input name="voegKenmerk" type="submit" class="submitFormButtonAuto" value="VOEG KENMERK TOE" style="cursor:pointer;"/>
                        <input name="addDelIndicator" type="submit" class="submitFormButtonAuto" value="NAAR INDICATOREN" style="cursor:pointer;"/>
                        <?php
                    }
                    elseif(isset($_POST['voegKenmerk'])) {
                        echo "Typ hier het nieuwe kenmerk:"
                        ?> 
                            <input name="toevoegenkenmerk" type="text" class="opmerkingField" />
                            <input name="addDelKenmerk" type="submit" class="submitFormButtonAuto" value="TERUG NAAR KENMERKEN" style="cursor:pointer;"/>
                            <input name="slaKenmerk" type="submit" class="submitFormButtonAuto" value="SLA KENMERK OP" style="cursor:pointer;"/>
                        <?php
                    }
                    elseif(isset($_POST['slaKenmerk'])) {

                        $toetevoegen = $_POST['toevoegenkenmerk'];
                        $opslaan = $getData->slaKenmerkOp($toetevoegen);

                        echo "Het kenmerk is toegevoegd en opgeslagen, gebruik onderstaande knop om terug te keren";
                        echo '<input name="addDelKenmerk" type="submit" class="submitFormButtonAuto" value="TERUG NAAR KENMERKEN" style="cursor:pointer;"/>';
                    }
                    elseif(isset($_POST['addDelIndicator'])) {
                        unset($_POST['addDelIndicator']);
                            echo "SELECTEER GEWENSTE INDICATOREN<br/><br/>";
                            $i=0;
                            foreach($_POST as $value) {
                                $kenmerkID = $value;
                                $kenmerkenThis = $getData->getSpecificKenmerk($value);
                                //pak de indicator id ($value)en haal de bijbehorende kenmerken op:
                                $indicatoren = $getData->getAllIndicatoren($value);
                                //rol de indicatoren onder elk kenmerk uit:
                                echo "<div class='indicatorwrap'><div class='indicatorkenmerk'>".$kenmerkenThis[0]['Kenmerk']."</div>";
                                if(!empty($indicatoren)) {
                                    foreach($indicatoren as $value2) {
                                        if(in_array($value2['Indicator_ID'], $auditIndicatoren)) {
                                        echo "<div class='kenmerkwrap'>
                                            <div class='kenmerkselect'>
                                                <input type='checkbox' CHECKED name='".$value2['Indicator_ID']."' value='".$value2['Indicator_ID'].",".$value2['Kenmerk_ID']."'>
                                            </div>
                                            <div class='kenmerknaam'>"
                                                .$value2['Indicator'].
                                            "</div></div>";  
                                        }
                                        else {
                                        echo "<div class='kenmerkwrap'>
                                            <div class='kenmerkselect'>
                                                <input type='checkbox' name='".$value2['Indicator_ID']."' value='".$value2['Indicator_ID'].",".$value2['Kenmerk_ID']."'>
                                            </div>
                                            <div class='kenmerknaam'>"
                                                .$value2['Indicator'].
                                            "</div></div>";  
                                        }

                                    }
                                }
                                echo "</div>";
                                $i++;  
                            }
                        ?>
                        <input name="addDelKenmerk" type="submit" class="submitFormButtonAuto" value="TERUG NAAR KENMERKSELECTIE" style="cursor:pointer;"/>
                        <input name="voegIndicator" type="submit" class="submitFormButtonAuto" value="VOEG INDICATOREN TOE" style="cursor:pointer;"/>
                        <input name="indicatorenOpslaan" type="submit" class="submitFormButtonAuto" value="SLA INDICATOREN OP" style="cursor:pointer;"/>
                        <?php
                    }
                    elseif(isset($_POST['indicatorenOpslaan'])) {
                        unset($_POST['indicatorenOpslaan']);

                        $i=0;
                        foreach($_POST as $value) {
                            $split[$i] = explode(",", $value);
                            $terugkenmerken[$i] = $split[$i][0];
                            $i++;             
                        }
                        echo "De door u geselecteerde indicatoren zijn succesvol opgeslagen in de database! klik op de onderstaande knop om terug te keren naar het auditoverzicht.";
                        $indicatorenOpslaan = implode(",", $terugkenmerken);
                        echo $indicatorenOpslaan;
                        $uploadData = $getData->updateIndicatoren($indicatorenOpslaan);
                        echo '<input name="backToAudit" type="submit" class="submitFormButtonAuto" value="TERUG NAAR OVERZICHT" style="cursor:pointer;"/>';
                        
                    }
                    elseif(isset($_POST['voegIndicator'])) {
                        echo "Kies het Kenmerk:";
                        unset($_POST['voegIndicator']);
                        echo "<select name='kenmerk' class='opmerkingField'>";
                        foreach($kenmerken as $value) {
                            echo "<option value='".$value['Kenmerk_ID']."'>".$value['Kenmerk']."</option>"; 
                        }
                        echo "</select>";
                        echo "<br/><br/><br/>Typ hier de nieuwe Indicator:";
                        $i=0;
                        foreach($_POST as $value) {
                            echo "<input type='hidden' value='".$value."' name='".$i."'>";
                            $i++;
                        }
                        ?> 
                            <input name="toevoegenkenmerk" type="text" class="opmerkingField" /> 
                            <input name="addDelIndicator" type="submit" class="submitFormButtonAuto" value="TERUG NAAR INDICATOREN" style="cursor:pointer;"/>
                            <input name="slaIndicator" type="submit" class="submitFormButtonAuto" value="SLA KENMERK OP" style="cursor:pointer;"/>
                        <?php
                    }
                    elseif(isset($_POST['slaIndicator'])) {
                        $kenmerkID = $_POST['kenmerk'];
                        unset($_POST['kenmerk']);
                        $indicator = $_POST['toevoegenkenmerk'];
                        unset($_POST['toevoegenkenmerk']);
                        unset($_POST['slaIndicator']);

                        $opslaan = $getData->slaIndicatorOp($kenmerkID, $indicator);
                        echo "De indicator is toegevoegd en opgeslagen, gebruik onderstaande knop om terug te keren";
                        $i = 0;
                        foreach($_POST as $value) {
                            echo "<input type='hidden' value='".$value."' name='".$i."'>";
                            $i++;
                        }
                        echo '<input name="addDelIndicator" type="submit" class="submitFormButtonAuto" value="TERUG NAAR INDICATOREN" style="cursor:pointer;"/>';
                    }
                    else { ?>
                    De naam van de audit:
                    <input name="auditName" type="text" class="opmerkingField" value="<?php echo $auditinfo[0]['AuditNaam']; ?>"/>
                    <br/><br/>De school waar de audit plaats vindt:
                    <input name="auditSchool" type="text" class="opmerkingField" value="<?php echo $auditinfo[0]['AuditSchool']; ?>"/>
                    <br/><br/>Het doel van de audit:
                    <input name="auditGoal" type="text" class="opmerkingField" value="<?php echo $auditinfo[0]['AuditDoel']; ?>"/>
                    <br/><br/><br/><br/>
                    <?php
                    //select all the indicatoren that were chosen for this audit:
                    $totalindicatoren = $auditinfo[0]['AuditIndicatoren'];
                    //explode the indicatoren that were chosen for this audit:
                    $selectedindicatoren = explode(",", $totalindicatoren);
                    //make sure everything is in the right order (low-high):
                    sort($selectedindicatoren);
                    
                    //first get all kenmerken (search full indicatoren array for indicatoren from audit)
                    //and put them in an array (all unique, so we can work from there:
                    $kenmerkenArray = array();
                    $i=0;
                    $p=0;
                    foreach($selectedindicatoren as $value) {
                        foreach($indicatoren1 as $value2) {
                            if($value2['Indicator_ID'] == $value){
                                $kenmerkID = $value2['Kenmerk_ID'];
                                if(!in_array($kenmerkID, $kenmerkenArray)) {
                                    $kenmerkenArray[$i] = $kenmerkID;
                                    $i++;
                                }
                                $indicatorenArray[$p]['IndicatorID'] = $value2['Indicator_ID'];
                                $indicatorenArray[$p]['Indicator'] = $value2['Indicator'];
                                $indicatorenArray[$p]['KenmerkID'] = $value2['Kenmerk_ID'];
                                $p++;
                            }
                        }
                    }
                    //for each kenmerk, create a container:
                    foreach($kenmerkenArray as $value) {
                        $score = $getData->getSpecificNorm($value, $auditID);
                        foreach($kenmerken as $value2) {
                            if($value == $value2['Kenmerk_ID']) {
                                $kenmerktoshow = $value2['Kenmerk'];
                            }
                        }
                        echo '<div class="kenmerkContainer">
                            <div class="kenmerkHeader">
                                KENMERK
                            </div>
                            <div class="kenmerkName">
                                '.$kenmerktoshow.'
                            </div>'; ?>
                        <div class="scoreContainer">
                            <div class="radioContainer1">
                                <b>Kies norm:</b>
                            </div>
                            <div class="radioContainer">
                                <div class="radioLabel">
                                    1
                                </div>
                                <div class="radioButton">
                                    <input class="radio" type="radio" name="<?php echo $value.'&score'; ?>" value="1"  <?php if($score[0]['Norm'] == 1) { echo "CHECKED"; }?>/>
                                </div>
                            </div>
                            <div class="radioContainer">
                                <div class="radioLabel">
                                    2
                                </div>
                                <div class="radioButton">
                                    <input class="radio" type="radio" name="<?php echo $value.'&score'; ?>" value="2"  <?php if($score[0]['Norm'] == 2) { echo "CHECKED"; }?>/>
                                </div>
                            </div>
                            <div class="radioContainer">
                                <div class="radioLabel">
                                    3
                                </div>
                                <div class="radioButton">
                                    <input class="radio" type="radio" name="<?php echo $value.'&score'; ?>" value="3"  <?php if($score[0]['Norm'] == 3) { echo "CHECKED"; }?>/>
                                </div>
                            </div>
                            <div class="radioContainer">
                                <div class="radioLabel">
                                    4
                                </div>
                                <div class="radioButton">
                                    <input class="radio" type="radio" name="<?php echo $value.'&score'; ?>" value="4"  <?php if($score[0]['Norm'] == 4) { echo "CHECKED"; }?>/>
                                </div>
                            </div>
                            <div class="radioContainer">
                                <div class="radioLabel">
                                    5
                                </div>
                                <div class="radioButton">
                                    <input class="radio" type="radio" name="<?php echo $value.'&score'; ?>" value="5"  <?php if($score[0]['Norm'] == 5) { echo "CHECKED"; }?>/>
                                </div>
                            </div>
                        </div>
                    <?php
                    foreach($indicatorenArray as $value3) {
                        if($value3['KenmerkID'] == $value) {
                            echo '<div class="indicatorHeader">
                                    INDICATOR
                                </div>';
                                $stringLength = strlen($value3['Indicator']); ?>
                                    <?php if($stringLength <= '65') { ?>
                                            <div class="indicatorName">
                                                <?php echo $value3['Indicator']; ?>
                                            </div>
                                            <?php 
                                            } else { ?>
                                                <div class="indicatorName2">
                                                    <?php echo $value3['Indicator']; ?>
                                                </div>
                                            <?php } 
                        }
                    }
                    echo "</div>";
                    }
                    ?>
                    <input name="addDelKenmerk" type="submit" class="submitFormButtonAuto" value="KENMERKEN & INDICATOREN TOEVOEGEN OF VERWIJDEREN" style="cursor:pointer;"/>
                    <input name="saveAudit" type="submit" class="submitFormButtonAuto" value="WIJZIGINGEN OPSLAAN" style="cursor:pointer;"/>
                    <input name="backToStart" type="submit" class="submitFormButtonAuto" value="TERUG NAAR START" style="cursor:pointer;"/>
                </form>
                    <?php } ?>
            </div>
        </div>
    </body>
</html>