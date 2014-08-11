<?php 
ini_set('session.gc_maxlifetime', 28800);
session_set_cookie_params(28800);
    session_start(); 
    require_once("_include/queryManager.php"); 
    $getData = new queryManager;
    $error = '';
    
   // print_r($_SESSION["auditName"]);
   // print_r($_SESSION["auditorID"]);
    echo $typecheck[0]["Audittype"];
    if(isset($_POST['newAuditor'])) {
        if(isset($_POST['auditorName']) && isset($_POST['rol'])) {
            $uploadData = $getData->setAuditor($_POST['auditorName'], $_POST['rol']);
            unset($_POST['auditorName']);
            unset($_POST['rol']);
            header("Location: startAudit.php");
        }
        else {
            if(!isset($_POST['auditorName']) && !isset($_POST['rol'])) {
                $error = 'Er kon geen nieuwe auditor worden toegevoegd omdat u geen NAAM en geen ROL geselecteerd heeft.<br/>Probeer het nogmaals.';
            }
            elseif(!isset($_POST['auditorName'])) {
                $error = 'Er kon geen nieuwe auditor worden toegevoegd omdat u geen NAAM geselecteerd heeft.<br/>Probeer het nogmaals.';
            }
            elseif(!isset($_POST['rol'])) {
                $error = 'Er kon geen nieuwe auditor worden toegevoegd omdat u geen ROL geselecteerd heeft.<br/>Probeer het nogmaals.';
            }
            else { $error = 'er kon geen nieuwe audit gestart worden omdat er een fout plaatsvond.<br/>Probeer het nogmaals.'; }
        }
    }
    elseif(isset($_POST['startAudit'])) {
        if(isset($_POST['auditorName2']) && isset($_POST['auditName'])) {
            $auditorID = $getData->getAuditor2($_POST['auditorName2']);
            
            $typecheck = $getData->checkType($_POST['auditName'], $auditorID[0]['Pers_ID']);
            if($_SESSION["type"] == 'Extern'){
                $type = 'Extern';
            }else{
                $type = 'Intern';
            }
            
             $_SESSION["auditName"]  = $_POST['auditName'];
             $_SESSION["auditorID"] = $auditorID;
            $auditName = $_POST["auditName"];
            
            //$auditorID = $_SESSION["auditor"];
            
            header("Location: perfAudit.php?a=".$auditName."&n=".$auditorID[0]['Pers_ID']."&t=".$type);
        }
        elseif(isset($_SESSION["auditName"]) && isset($_SESSION["auditorID"][0]['Pers_ID'])) {
             header("Location: perfAudit.php?a=".$_SESSION["auditName"]."&n=".$_SESSION["auditorID"][0]['Pers_ID']."&t=".$type);
        }
        
        else {
            if(!isset($_POST['auditorName2']) && !isset($_POST['auditName']) && !isset($_SESSION["auditorID"][0]['Pers_ID']) && !isset($_SESSION["auditName"])) {
                $error = 'Er kon geen audit gestart worden omdat u geen AUDITOR en geen AUDIT geselecteerd heeft.<br/>Probeer het nogmaals.';
            }
            elseif(!isset($_POST['auditorName2']) && !isset($_SESSION["auditorID"][0]['Pers_ID']) ) {
                $error = 'Er kon geen audit gestart worden omdat u geen AUDITOR geselecteerd heeft.<br/>Probeer het nogmaals.';
            }
            elseif(!isset($_POST['auditName']) && !isset($_SESSION["auditName"])) {
                $error = 'Er kon geen audit gestart worden omdat u geen AUDIT geselecteerd heeft.<br/>Probeer het nogmaals.';
            }
            else { $error = 'er kon geen nieuwe audit gestart worden omdat er een fout plaatsvond.<br/>Probeer het nogmaals.'; }
        }
    }
    elseif(isset($_POST['viewOverview'])) {
        if(isset($_POST['auditorName2']) && isset($_POST['auditName'])) {
            $auditorID = $getData->getAuditor2($_POST['auditorName2']);
            $typecheck = $getData->checkType($_POST['auditName'], $auditorID[0]['Pers_ID']);
            if($_SESSION["type"] == 'Extern'){
                $type = 'Extern';
            }else{
                $type = 'Intern';
            }
              $_SESSION["auditName"]  = $_POST['auditName'];
             $_SESSION["auditorID"] = $auditorID;
            $auditName = $_POST["auditName"];
            
            //$auditorID = $_SESSION["auditor"];
            
            header("Location: overviewAudit.php?a=".$auditName."&n=".$auditorID[0]['Pers_ID']."&t=".$type);
        }
         elseif(isset($_SESSION["auditName"]) && isset($_SESSION["auditorID"][0]['Pers_ID'])) {
             header("Location: overviewAudit.php?a=".$_SESSION["auditName"]."&n=".$_SESSION["auditorID"][0]['Pers_ID']."&t=".$type);
        }
        else {
            if(!isset($_POST['auditorName2']) && !isset($_POST['auditName']) && !isset($_SESSION["auditorID"][0]['Pers_ID']) && !isset($_SESSION["auditName"])) {
                $error = 'Er kon geen overzicht worden geladen omdat u geen AUDITOR en geen AUDIT geselecteerd heeft.<br/>Probeer het nogmaals.';
            }
            elseif(!isset($_POST['auditorName2']) && !isset($_SESSION["auditorID"][0]['Pers_ID'])) {
                $error = 'Er kon geen overzicht worden geladen omdat u geen AUDITOR geselecteerd heeft.<br/>Probeer het nogmaals.';
            }
            elseif(!isset($_POST['auditName']) && !isset($_SESSION["auditName"])) {
                $error = 'Er kon geen overzicht worden geladen omdat u geen AUDIT geselecteerd heeft.<br/>Probeer het nogmaals.';
            }
            else { $error = 'er kon geen overzicht worden geladen omdat er een fout plaatsvond.<br/>Probeer het nogmaals.'; }
        }
    }
    else {}
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="_include/css/startAudit.css"/>
        <!--[if IE]><link rel="stylesheet" type="text/css" href="_include/css/startAuditIE.css"/><![endif]--> 
       
        <title>Audit App Pilot - Start Audit</title>
        <script language="javascript"> 
            function toggle() {
                var ele = document.getElementById("selectExisting");
                var ele2 = document.getElementById("addNew");
                var ele3 = document.getElementById("contentRight");
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
    <?php
        $audit = $getData->getAudits();
        $kenmerk = $getData->getKenmerken();
        $namen = $getData->getAuditors();
        $rol = $getData->getRoles();
        $auditLength = count($audit);
        $kenmerkLength = count($kenmerk);
        $naamLength = count($namen);
        if($naamLength == 1) { $naamLength = 2; }
        $rolLength = count($rol);
    ?>
    <body id="body">
        <div id="contentcontainer">
            <div id="pageTitle">
                START AUDIT
            </div>
            <div id="pageContent">
                <?php 
                //if there is an error, display it:
                    if(!empty($error)) { ?>
                    <br/>
                    <div id="pageError"><img src="_include/images/error_1.jpg" alt=""/><?php echo $error; ?></div>
                <?php } ?>
                <form action="" method="POST">
                    <div id="contentLeft">
                        <div id="selectExisting" style="display:block">
                            <div class="selectboxHeader">
                                Kies een naam:
                            </div>
                            <?php if($naamLength != 0) { ?>
                                <div class="selectboxDiv" style="dislay:block">
                                    <?php 
                                        $i=0;
                                        echo '<select name="auditorName2" size="'.$naamLength.'" class="selectbox">';
                                            foreach($namen as $value) {
                                                if($i % 2) { $p=2; } else { $p=1; }                          
                                                echo '<option class="selectboxItem'.$p.'">'.$value['Naam'];
                                                $i++;
                                            } 
                                        echo '</select>';
                                    ?>
                                </div>
                            <?php } else { ?>
                                <div class="selectboxEmpty">Er zijn geen namen beschikbaar, voeg een nieuwe toe:</div>
                            <?php } ?>
                            <div class="submitButton">
                                <a href="javascript:toggle();">VOEG NIEUWE AUDITOR TOE</a>
                            </div>
                        </div>
                        <div id="addNew" style="display:none">
                            <div class="inputfieldHeader">
                                Voer uw naam in:
                            </div>
                            <input type="text" name="auditorName" class="inputfield" value="Voornaam Achternaam" onfocus="if(this.value=='Voornaam Achternaam')this.value='';" onblur="if(this.value=='')this.value='Voornaam Achternaam';"/>
                            <div class="inputfieldHeader">
                                Kies uw rol:
                            </div>
                            <div class="selectboxDivRol">
                                <?php 
                                    $i=0;
                                    echo '<select size="'.$rolLength.'" class="selectbox" name="rol">';
                                        foreach($rol as $value) {
                                            if($i % 2) { $p=2; } else { $p=1; }                          
                                            echo '<option  value="'.$value['Rol_ID'].'" class="selectboxItem'.$p.'">&nbsp;&nbsp;&nbsp;'.$value['Rol'];
                                            $i++;
                                        } 
                                    echo '</select>';
                                ?>
                            </div>
                            <input  name="newAuditor" type="submit" class="submitFormButton" value="TOEVOEGEN" style="cursor:pointer;"/>
                            <div class="submitButton">
                                <a href="javascript:toggle();">TERUG</a>
                            </div>
                        </div>
                    </div>
                    <div id="contentRight">
                        <div class="selectboxWideHeader">
                            Kies een audit:
                        </div>
                        <div class="selectboxWideDiv">
                            <?php 
                                $i=0;
                                echo '<select name="auditName" size="'.$auditLength.'" class="selectboxWide">';
                                    foreach($audit as $value) {
                                        if($i % 2) { $p=2; } else { $p=1; }
                                        echo '<option value="'.$value['Audit_ID'].'"class="selectboxWideItem'.$p.'">&nbsp;&nbsp;&nbsp;'.$value['AuditNaam'];
                                        $i++;
                                    } 
                                echo '</select>';
                            ?>
                        </div>
                        <input name="startAudit" type="submit" class="submitFormButton" value="START AUDIT" style="cursor:pointer;"/>
                        <input name="viewOverview" type="submit" class="submitFormButton" value="BEKIJK OVERZICHT" style="cursor:pointer;"/>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>