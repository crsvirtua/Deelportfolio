<?php 
    session_start(); 
    require_once("_include/queryManager.php"); 
    $getData = new queryManager;
    $error = '';
    $kenmerken = $getData->getAllKenmerken();
    if(isset($_POST['backToStart'])) {
        header("Location: adminAudit.php");
    }
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="_include/css/backendCSS.css"/> 
        <title>Audit App Pilot - Audit Aanmaken</title>
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
                <?php } ?>
                    
                <form action="" method="POST">  
                   
                    <?php 
                        if(isset($_POST['kiesKenmerk'])) {
                            echo "SELECTEER GEWENSTE KENMERKEN<br/><br/>";
                            foreach($kenmerken as $value) {
                                echo "<div class='kenmerkwrap'>
                                        <div class='kenmerkselect'>
                                            <input type='checkbox' name='".$value['Kenmerk_ID']."' value='".$value['Kenmerk_ID']."'>
                                        </div>
                                        <div class='kenmerknaam'>"
                                            .$value['Kenmerk'].
                                        "</div>
                                     </div>";
                            }
                          ?>
                          <input name="voegKenmerk" type="submit" class="submitFormButtonAuto" value="VOEG NIEUW KENMERK TOE" style="cursor:pointer;"/>
                          <input name="selectIndicatoren" type="submit" class="submitFormButtonAuto" value="VOLGENDE STAP" style="cursor:pointer;"/>
                          <input name="backToStart" type="submit" class="submitFormButtonAuto" value="TERUG NAAR OVERZICHT " style="cursor:pointer;"/>
                          <?php
                        }
                        elseif(isset($_POST['voegKenmerk'])) {
                            echo "Typ hier het nieuwe kenmerk:"
                            ?> 
                                <input name="toevoegenkenmerk" type="text" class="opmerkingField" />
                                <input name="kiesKenmerk" type="submit" class="submitFormButtonAuto" value="TERUG NAAR KENMERKEN" style="cursor:pointer;"/>
                                <input name="slaKenmerk" type="submit" class="submitFormButtonAuto" value="SLA KENMERK OP" style="cursor:pointer;"/>
                            <?php
                        }
                        elseif(isset($_POST['slaKenmerk'])) {
                            $toetevoegen = $_POST['toevoegenkenmerk'];
                            $opslaan = $getData->slaKenmerkOp($toetevoegen);
                            echo "Het kenmerk is toegevoegd en opgeslagen, gebruik onderstaande knop om terug te keren";
                            echo '<input name="kiesKenmerk" type="submit" class="submitFormButtonAuto" value="TERUG NAAR KENMERKEN" style="cursor:pointer;"/>';
                        }
                        elseif(isset($_POST['selectIndicatoren'])) {
                            echo "SELECTEER GEWENSTE INDICATOREN<br/><br/>";
                            unset($_POST['selectIndicatoren']);
                            $i=0;
                            if(!empty($_POST)) {
                                foreach($_POST as $value) {
                                    $kenmerkenThis = $getData->getSpecificKenmerk($value);
                                    //pak de indicator id ($value)en haal de bijbehorende kenmerken op:
                                    $indicatoren = $getData->getAllIndicatoren($value);
                                    //rol de indicatoren onder elk kenmerk uit:
                                    echo "<div class='indicatorwrap'><div class='indicatorkenmerk'>".$kenmerkenThis[0]['Kenmerk']."</div>";
                                    if(!empty($indicatoren)) {
                                        foreach($indicatoren as $value2) {
                                        echo "<div class='kenmerkwrap'>
                                            <div class='kenmerkselect'>
                                                <input type='checkbox' name='".$value2['Indicator_ID']."' value='".$value2['Indicator_ID'].",".$value2['Kenmerk_ID']."'>
                                            </div>
                                            <div class='kenmerknaam'>"
                                                .$value2['Indicator'].
                                            "</div></div>";
                                        }
                                    }
                                    echo "</div>";
                                    $i++;  
                                }
                            }
                            else {
                                echo "Er zijn geen kenmerken geselecteerd, ga terug om kenmerken te selecteren<br/><br/>";
                            }
                          $i=0;
                          ?>
                          <input name="kiesKenmerk" type="submit" class="submitFormButtonAuto" value="TERUG NAAR KENMERKSELECTIE" style="cursor:pointer;"/>
                          <input name="voegIndicator" type="submit" class="submitFormButtonAuto" value="VOEG NIEUWE INDICATOREN TOE" style="cursor:pointer;"/>
                          <input name="toonAudit" type="submit" class="submitFormButtonAuto" value="TOON AUDIT" style="cursor:pointer;"/>
                          <?php
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
                                <input name="selectIndicatoren" type="submit" class="submitFormButtonAuto" value="TERUG NAAR INDICATOREN" style="cursor:pointer;"/>
                                <input name="slaIndicator" type="submit" class="submitFormButtonAuto" value="SLA INDICATOR OP" style="cursor:pointer;"/>
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
                            echo '<input name="selectIndicatoren" type="submit" class="submitFormButtonAuto" value="TERUG NAAR INDICATOREN" style="cursor:pointer;"/>';
                        }
                        elseif(isset($_POST['toonAudit'])) {
                            unset($_POST['toonAudit']);
                            $i=0;
                            if(!empty($_POST)) {
                                foreach($_POST as $value) {
                                //audit tonen zoals deze ook in de front-end is (KOPIEREN VAN RICHARD, WANNEER DEZE AF IS):
                                $split[$i] = explode(",", $value);
                                                              
                                //sets the kenmerk_id's for eventual "step back"
                                $terugkenmerken[$i] = $split[$i][1];
                                $i++;                           
                            }
                            $terugkenmerken = array_unique($terugkenmerken); 
                            }
                            

                            //each indicator was saved in a different $split array:
                            //start building the view:
                            //first get the specific kenmerken:
                            $p=0;
                            ?>
                            Typ hier de naam van de audit:
                            <input name="auditName" type="text" class="opmerkingField" />
                            <br/><br/>Typ hier de school waar de audit plaats vindt:
                            <input name="auditSchool" type="text" class="opmerkingField" />
                            <br/><br/>Typ hier het doel van de audit:
                            <input name="auditGoal" type="text" class="opmerkingField" />
                            <br/><br/><br/><br/>
                            <?php
                            if(!empty($terugkenmerken)) {
                                foreach($terugkenmerken as $value) {
                                foreach($kenmerken as $value2) {
                                    if($value2['Kenmerk_ID'] == $value) {
                                        echo '<div class="kenmerkContainer">
                                                <div class="kenmerkHeader">
                                                    KENMERK
                                                </div>
                                                <div class="kenmerkName">
                                                    '.$value2['Kenmerk'].'
                                                </div>'; ?>
                                            <div class="scoreContainer">
                                                <div class="radioContainer1">
                                                    <b>Kies de norm:</b>
                                                </div>
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
                                            </div>
                                                <?php
                                                foreach($split as $value3) {
                                                    if($value3[1] == $value) {
                                                        $indicator = $getData->getIndicatorSingle($value3[0]);
                                                       echo '<div class="indicatorHeader">
                                                               INDICATOR
                                                            </div>';
                                                            //show the indicator:
                                                            $stringLength = strlen($indicator[0]['Indicator']); ?>
                                                            <?php if($stringLength <= '65') { ?>
                                                                    <div class="indicatorName">
                                                                        <?php echo $indicator[0]['Indicator']; ?>
                                                                        <input type="hidden" name="<?php echo $indicator[0]['Indicator_ID'];?>" value="<?php echo $indicator[0]['Indicator_ID'];?>"/>
                                                                    </div>
                                                                    <?php 
                                                                    } else { ?>
                                                                        <div class="indicatorName2">
                                                                            <?php echo $indicator[0]['Indicator']; ?>
                                                                            <input type="hidden" name="<?php echo $indicator[0]['Indicator_ID'];?>" value="<?php echo $indicator[0]['Indicator_ID'];?>"/>
                                                                        </div>
                                                                    <?php } 
                                                        }
                                                        
                                                    }
                                                echo "</div>";
                                    }
                                }
                            }
                            }
                           
                            //volgende regel stuurt de kenmerken terug voor de indicatorselectie:
                            $o = 0;
                            if(!empty($terugkenmerken)) {
                                foreach($terugkenmerken as $value) {
                                echo '<input type="hidden" name="'.$o.'" value="'.$value.'"/>';
                                $o++;
                            }
                            }
                            ?>
                          
                            <input name="selectIndicatoren" type="submit" class="submitFormButtonAuto" value="TERUG NAAR INDICATORSELECTIE" style="cursor:pointer;"/>
                            <input name="saveAudit" type="submit" class="submitFormButtonAuto" value="AUDIT OPSLAAN" style="cursor:pointer;"/>
                            <?php
                        }
                        elseif(isset($_POST['saveAudit'])) {
                            unset($_POST['saveAudit']);
                            $i=0;
                            $p=0;
                            foreach($_POST as $value) {
                                if(array_key_exists($i."&score", $_POST)) {
                                    $norm[$p] = $_POST[$i."&score"];
                                    $normID[$p] = $i;
                                    unset($_POST[$i."&score"]);
                                    $p++;
                                }
                                $i++;
                            }
                            //get the school- and auditname:
                            $school = $_POST['auditSchool'];
                            $naam = $_POST['auditName'];
                            $doel = $_POST['auditGoal'];
                            unset($_POST['auditSchool']);
                            unset($_POST['auditName']);
                            unset($_POST['auditGoal']);

                            //make sure that all indicators are unique:
                            $values = array_unique($_POST);
                            $values = implode(",", $values);
                            
                            //actually save the audit:
                            $saveAudit = $getData->saveAudit($naam, $school, $doel, $values);
                            $auditID = $getData->getLastSavedAudit();
                            $e=0;
                            if(!empty($norm)) {
                                foreach($norm as $value) {
                                    $saveNorms = $getData->saveNormen($auditID[0]['Audit_ID'], $normID[$e], $norm[$e]);
                                    $e++;
                                }
                            }
                            echo "De audit is succesvol opgeslagen, klik op de onderstaande knop om terug te keren naar het overzicht<br/>";
                            ?><input name="backToStart" type="submit" class="submitFormButtonAuto" value="TERUG NAAR START" style="cursor:pointer;"/><?php
                        }
                        else {
                          ?>
                          <input name="kiesKenmerk" type="submit" class="submitFormButtonAuto" value="KIES KENMERKEN" style="cursor:pointer;"/>
                          <input name="backToStart" type="submit" class="submitFormButtonAuto" value="TERUG NAAR OVERZICHT " style="cursor:pointer;"/>
                          <?php
                        }
                    ?>
                </form>
            </div>
        </div>
    </body>
</html>