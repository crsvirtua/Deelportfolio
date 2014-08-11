<?php 
    session_start(); 
    require_once("_include/queryManager.php"); 
    $getData = new queryManager;
    $error = '';
    if(isset($_POST['createAudit'])) {
        header("Location: createAudit.php");
    }
    elseif(isset($_POST['startAudit'])) {
        header("Location: startAudit.php");
    }
    elseif(isset($_POST['editAudit'])) {
        header("Location: editAudit.php");
    }
    else {}
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="_include/css/startAudit.css"/>
        <title>Audit App Pilot - Audit Beheer</title>
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
                AUDIT BEHEER
            </div>
            <div id="pageContent">
                <?php 
                //if there is an error, display it:
                    if(!empty($error)) { ?>
                    <br/>
                    <div id="pageError"><img src="_include/images/error_1.jpg" alt=""/><?php echo $error; ?></div>
                <?php } ?>
                <form action="" method="POST">
                    <input name="startAudit" type="submit" class="submitFormButton" value="START AUDIT" style="cursor:pointer;"/>
                    <input name="createAudit" type="submit" class="submitFormButton" value="AUDIT AANMAKEN" style="cursor:pointer;"/>
                    <input name="editAudit" type="submit" class="submitFormButton" value="AUDIT AANPASSEN" style="cursor:pointer;"/>
<!--                    <div id="contentLeft">
                        <input name="startAudit" type="submit" class="submitFormButton" value="START AUDIT" style="cursor:pointer;"/>
                    </div>
                    <div id="contentRight">
                        <input name="createAudit" type="submit" class="submitFormButton" value="AUDIT AANMAKEN" style="cursor:pointer;"/>
                    </div>-->
                </form>
            </div>
        </div>
    </body>
</html>