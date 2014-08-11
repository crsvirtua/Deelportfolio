<?php

//Designed and written in the year 2012, for ASG, by:
//Peter van Kleef, Richard Floris & Pepijn de Vries.

session_start();
require_once MODEL_USER;
require_once MODEL_SCHOOL;

//IF the user is not logged in or the authenticationcode is not equal to the one in the DB:
$checkUser = new User;
$authUser = $checkUser->authenticateUser($_SESSION['uname'], $_SESSION['authcode']);

if($authUser == 'authUnSucc') {
    //destroy the current session:
    session_destroy();
    //go to the login page:
    header('Location: '.BACKEND_LINK_ROOT);
} else {}

//determine what rights this user has on this page:
$currentPage = 'schoolUpdate';
$rights = $checkUser->checkRights($_SESSION['authcode'], $_SESSION['uname'], $currentPage);
if($rights == 'VIEW_EDIT_FALSE') {
    if($_SESSION["lastpage"] == '') { $_SESSION["lastpage"] = 'overview'; }
    header('Location:'.$_SESSION["lastpage"]);
}

$urlParameters = explode('/',$_SERVER['REQUEST_URI']); 
array_shift($urlParameters); 
$urlParameter = $urlParameters[2];

$showItem = new school;
$showTemp = $showItem->loadTemp($urlParameter);

if(empty($showTemp)) {
    $pageStatus = 'error';
}

if(isset($_POST['approveSubmit'])) {
    $dataToUpload = new school;
    $goUpload = $dataToUpload->uploadData($_POST);
    header('Location:'.$_SESSION['lastpage']);
}

$_SESSION["lastpage"] = $currentPage;

?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <?php echo '<link rel="stylesheet" type="text/css" href="'.CSSB_DEFAULT.'" />'; ?>
        <?php echo '<link rel="stylesheet" type="text/css" href="'.CSSB_HEADER.'" />'; ?>
        <?php echo '<link rel="stylesheet" type="text/css" href="'.CSSB_EDITCONTENT.'" />'; ?>
        <?php echo'<link rel="stylesheet" type="text/css" href="'.CSSF_SCHOOLUPDATE.'" />'; ?>
        <title>SCHOOLINZICHT - Backend</title>
        <script>
            /* This script and many more are available free online at
            The JavaScript Source!! http://www.javascriptsource.com
            Created by: Paul Tuckey | http://tuckey.org/
            Modified by: EZboy yuriy.demchenko at gmail.com */

            function countLines(strtocount, cols) {
            var hard_lines = 1;
            var last = 0;
            while ( true ) {
                last = strtocount.indexOf("\n", last+1);
                hard_lines ++;
                if ( last == -1 ) break;
            }
            var soft_lines = Math.round(strtocount.length / (cols-1));
            var hard = eval("hard_lines  " + unescape("%3e") + "soft_lines;");
            if ( hard ) soft_lines = hard_lines;
            return soft_lines;
            }

            function cleanForm() {
            for(var no=0;no<document.forms.length;no++){
                var the_form = document.forms[no];
                for( var x in the_form ) {
                if ( ! the_form[x] ) continue;
                if( typeof the_form[x].rows != "number" ) continue;

                if(!the_form[x].onkeyup) {the_form[x].onkeyup=function()
                {this.rows = countLines(this.value,this.cols)-1;};the_form[x].rows =
                countLines(the_form[x].value,the_form[x].cols) -1;}
                }
            }
            }

            // Multiple onload function created by: Simon Willison
            // http://simon.incutio.com/archive/2004/05/26/addLoadEvent
            function addLoadEvent(func) {
            var oldonload = window.onload;
            if (typeof window.onload != 'function') {
                window.onload = func;
            } else {
                window.onload = function() {
                if (oldonload) {
                    oldonload();
                }
                func();
                }
            }
            }

            addLoadEvent(function() {
            cleanForm();
            });
        </script>
    </head>
    <body class="body">
        <?php include_once("views/components/backendHeader.php"); ?>
        <div id="contentcontainer">
            <?php if($rights == 'VIEW_TRUE') {}
            else { ?>
            <div id="editcontentcontainer">
                <?php if($pageStatus == 'error') { ?>
                    Er kon geen data worden opgehaald voor de door u gekozen school.<br/>
                    De wijzigingen waarvan u bericht hebt gehad zijn waarschijnlijk al doorgevoerd.<br/><br/>
                    <?php echo '<a href="'.BACKEND_LINK_ROOT.'articleList">klik hier om terug te keren naar de beginpagina</a>'; ?> 
                <?php } 
                else { echo $_SESSION['error']; $_SESSSION['error'] = ''; ?>
                    <div class="formfieldcontentcontainer">
                        <div class="formfieldcontentleft"></div>
                        <div class="formfieldcontentmid">De gewijzigde content:</div>
                        <div class="formfieldcontentright">Uw commentaar (wanneer NIET geselecteerd/goedgekeurd):</div>
                    </div>
                <form action="" method="POST">
                    <?php $numberOfItems = count($showTemp);  ?>
                    <input type="hidden" name="LENGTH" value="<?php echo $numberOfItems; ?>"/>
                   <?php 
                   $p = 0;
                   foreach($showTemp as $keyValue1) {
                       $i = 0;
                        foreach($keyValue1 as $keyValue) { 
                            $i++; 
                            if($i == 1) { ?>
                                <div class="formfieldcontentcontainerOverflow">
                                    <div class="formfieldcontentleftOverflow">
                                        <input type="hidden" name="BRIN" value="<?php echo $urlParameter; ?>"/>
                                        <input type="hidden" name="<?php echo 'ID&'.$p; ?>" value="<?php echo $p; ?>"/>
                                        <input type="hidden" name="<?php echo 'type&'.$p; ?>" value="<?php echo $keyValue; ?>"/>
                                        <input type="hidden" name="<?php echo 'approve&'.$p; ?>" value="notApproved"/>
                                        <input type="checkbox" name="<?php echo 'approve&'.$p; ?>" value="approved"/>
                                    </div>
                                    <div class="formfieldcontentmidOverflow">
                                        <div class="loginitem">
                                            <div class="loginitemtitle"><?php echo $keyValue; ?></div>
                                            <textarea readonly="READONLY" name="<?php echo 'content&'.$p; ?>"
                            <?php }
                            if($i == 2) { ?>
                                            class="loginitemcontentOverflow"><?php  echo $keyValue; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="formfieldcontentrightOverflow">
                                        <input type="text" name="<?php echo 'comment&'.$p; ?>" class="loginitemcontentcomment"/>
                                    </div>
  
                                </div>
                    <?php } } $p++; } ?>
                    <?php echo '<a href="'.BACKEND_LINK_ROOT.'articleList" class="editpagecancel">ANNULEREN</a>'; ?>
                    <input style="cursor: pointer;" type="submit" name="approveSubmit" value="DOORVOEREN" class="editpagesubmit"/>
                </form>
                <?php } ?>
            </div>
            <?php } ?>
            ..
        </div>
    </body>
</html>