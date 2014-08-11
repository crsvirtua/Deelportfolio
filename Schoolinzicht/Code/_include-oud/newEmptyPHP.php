<?php 

//Designed and written in the year 2012, for ASG, by:
//Peter van Kleef, Richard Floris & Pepijn de Vries.

require_once MODEL_SCHOOL;

if(isset($_POST["loginSubmit"])) {
    if(!empty($_POST["emailAddress"]) && !empty($_POST["BRIN"])) {
        $checkLogin = new School;
        $pageStatus = $checkLogin->authSchool($_POST["emailAddress"], $_POST['BRIN']);
    }
    else  { $pageStatus = 'authUnSucc'; }
    
}
if(isset($_POST["updateSubmit"])) {
    $submitUpdate = new School;
    $pageStatus = $submitUpdate->schoolUpdate($_POST);
}
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <?php  echo'<link rel="stylesheet" type="text/css" href="'.CSSF_HOME.'" />';
               echo'<link rel="stylesheet" type="text/css" href="'.CSSF_HEADER.'" />';
               echo'<link rel="stylesheet" type="text/css" href="'.CSSF_HELPTEXT.'" />'; 
               echo'<link rel="stylesheet" type="text/css" href="'.CSSF_DEFAULT.'" />';
               echo'<link rel="stylesheet" type="text/css" href="'.CSSB_LOGIN.'" />';
               echo'<link rel="stylesheet" type="text/css" href="'.CSSF_SCHOOLUPDATE.'" />'; ?>
        <?php if($pageStatus == 'uploadSucc') { echo '<meta http-equiv="refresh" content="5; URL='.FRONTEND_LINK_ROOT.'home">'; } else { } ?>
        <title>SCHOOLINZICHT</title>
    </head>
    <body class="body">
        <div id="header">
            <div id="headercontainer">      
                <?php include_once("views/components/frontendHeader.php"); ?>
            </div>
        </div>
        <div id="helptext">     
            <?php include_once("views/components/infotext.php"); ?>
        </div>
        <div id="content">
            <?php 
                if($pageStatus == 'authSucc') { 
                    $getFunction = 'getFrontendSchool';
                    $contenttoshow = new BaseModel;
                    $content = $contenttoshow->showItem($getFunction, $_POST['BRIN']);
                    $getFunction = 'getTempData';
                    $tempcontent = $contenttoshow->showItem($getFunction, $_POST['BRIN']);
                    
                    foreach($tempcontent as $value) {
                        $content[0][$value["contentName"]] = $value["content"];
                    }
                    ?>
                    <div class="schoolLogin">
                        <form action="" method="POST">
                            <div class="formfieldcontentcontainer">
                                <div class="formfieldcontentmid">
                                    <div class="loginitemtitle">BRIN:</div>
                                    <input type="text" name="BRIN" class="loginitemcontentgrey" readonly="readonly" Value="<?php  echo $_POST['BRIN']; ?>"/>
                                </div>
                                <div class="formfieldcontentright">
                                    <?php foreach($tempcontent as $key) {
                                        if($key['contentName'] != 'BRIN' || $key['comment'] == '') {  } else { ?>
                                            <input type="text" name="comment" class="loginitemcontentcomment" value="<?php echo $key['comment']; ?>"/>
                                    <?php }} ?>
                                </div>
                            </div>
                            <div class="formfieldcontentcontainer">
                                <div class="formfieldcontentmid">
                                    <div class="loginitemtitle">EMAIL:</div>
                                    <input type="text" name="emailAddress" class="loginitemcontent"  Value="<?php  echo $_POST['emailAddress']; ?>"/>
                                </div>
                                <div class="formfieldcontentright">
                                    <?php foreach($tempcontent as $key) {
                                        if($key['contentName'] != 'emailAddress' || $key['comment'] == '') {  } else { ?>
                                            <input type="text" name="comment" class="loginitemcontentcomment" value="<?php echo $key['comment']; ?>"/>
                                    <?php }} ?>
                                </div>
                            </div>
                            <div class="formfieldcontentcontainer">
                                <div class="formfieldcontentmid">
                                    <div class="loginitemtitle">Schoolnaam:</div>
                                    <input type="text" name="schoolName" class="loginitemcontentgrey"  readonly="readonly" Value="<?php  echo $content[0]['schoolName']; ?>"/>
                                </div>
                                <div class="formfieldcontentright">
                                    <?php foreach($tempcontent as $key) {
                                        if($key['contentName'] != 'schoolName' || $key['comment'] == '') {  } else { ?>
                                            <input type="text" name="comment" class="loginitemcontentcomment" value="<?php echo $key['comment']; ?>"/>
                                    <?php }} ?>
                                </div>
                            </div>
                            <div class="formfieldcontentcontainer">
                                <div class="formfieldcontentmid">
                                    <div class="loginitemtitle">Educatie Type:</div>
                                    <input type="text" name="educationType" class="loginitemcontentgrey"  readonly="readonly" Value="<?php  echo $content[0]['educationType']; ?>"/>
                                </div>
                                <div class="formfieldcontentright">
                                    <?php foreach($tempcontent as $key) {
                                        if($key['contentName'] != 'educationType' || $key['comment'] == '') {  } else { ?>
                                            <input type="text" name="comment" class="loginitemcontentcomment" value="<?php echo $key['comment']; ?>"/>
                                    <?php }} ?>
                                </div>
                            </div>
                            <div class="formfieldcontentcontainer">
                                <div class="formfieldcontentmid">
                                    <div class="loginitemtitle">Bestuur:</div>
                                    <input type="text" name="boardName" class="loginitemcontentgrey" readonly="readonly" Value="<?php  echo $content[0]['boardName']; ?>"/>
                                </div>
                                <div class="formfieldcontentright">
                                    <?php foreach($tempcontent as $key) {
                                        if($key['contentName'] != 'boardName' || $key['comment'] == '') {  } else { ?>
                                            <input type="text" name="comment" class="loginitemcontentcomment" value="<?php echo $key['comment']; ?>"/>
                                    <?php }} ?>
                                </div>
                            </div>
                            <div class="formfieldcontentcontainer">
                                <div class="formfieldcontentmid">
                                    <div class="loginitemtitle">School Type:</div>
                                    <input type="text" name="schoolType" class="loginitemcontentgrey" readonly="readonly" Value="<?php  echo $content[0]['schoolType']; ?>"/>
                                </div>
                                <div class="formfieldcontentright">
                                    <?php foreach($tempcontent as $key) {
                                        if($key['contentName'] != 'schoolType' || $key['comment'] == '') {  } else { ?>
                                            <input type="text" name="comment" class="loginitemcontentcomment" value="<?php echo $key['comment']; ?>"/>
                                    <?php }} ?>
                                </div>
                            </div>
                            <div class="formfieldcontentcontainer">
                                <div class="formfieldcontentmid">
                                    <div class="loginitemtitle">Website:</div>
                                    <input type="text" name="website" class="loginitemcontent"  Value="<?php  echo $content[0]['website']; ?>"/>
                                </div>
                                <div class="formfieldcontentright">
                                    <?php foreach($tempcontent as $key) {
                                        if($key['contentName'] != 'website' || $key['comment'] == '') {  } else { ?>
                                            <input type="text" name="comment" class="loginitemcontentcomment" value="<?php echo $key['comment']; ?>"/>
                                    <?php }} ?>
                                </div>
                            </div>
                            <div class="formfieldcontentcontainer">
                                <div class="formfieldcontentmid">
                                    <div class="loginitemtitle">Adres:</div>
                                    <input type="text" name="address" class="loginitemcontentgrey" readonly="readonly" Value="<?php  echo $content[0]['address']; ?>"/>
                                </div>
                                <div class="formfieldcontentright">
                                    <?php foreach($tempcontent as $key) {
                                        if($key['contentName'] != 'address' || $key['comment'] == '') {  } else { ?>
                                            <input type="text" name="comment" class="loginitemcontentcomment" value="<?php echo $key['comment']; ?>"/>
                                    <?php }} ?>
                                </div>
                            </div>
                            <div class="formfieldcontentcontainer">
                                <div class="formfieldcontentmid">
                                    <div class="loginitemtitle">Postcode:</div>
                                    <input type="text" name="postalCode" class="loginitemcontentgrey" readonly="readonly" Value="<?php  echo $content[0]['postalCode']; ?>"/>
                                </div>
                                <div class="formfieldcontentright">
                                    <?php foreach($tempcontent as $key) {
                                        if($key['contentName'] != 'postalCode' || $key['comment'] == '') {  } else { ?>
                                            <input type="text" name="comment" class="loginitemcontentcomment" value="<?php echo $key['comment']; ?>"/>
                                    <?php }} ?>
                                </div>
                            </div>
                            <div class="formfieldcontentcontainer">
                                <div class="formfieldcontentmid">
                                    <div class="loginitemtitle">Logopad:</div>
                                    <input type="text" name="logoPath" class="loginitemcontent"  Value="<?php  echo $content[0]['logoPath']; ?>"/>
                                </div>
                                <div class="formfieldcontentright">
                                    <?php foreach($tempcontent as $key) {
                                        if($key['contentName'] != 'logoPath' || $key['comment'] == '') {  } else { ?>
                                            <input type="text" name="comment" class="loginitemcontentcomment" value="<?php echo $key['comment']; ?>"/>
                                    <?php }} ?>
                                </div>
                            </div>
                            <div class="formfieldcontentcontainer">
                                <div class="formfieldcontentmid">
                                    <div class="loginitemtitle">Naschoolse:</div>
                                    <input type="text" name="childCare" class="loginitemcontent"  Value="<?php  echo $content[0]['childCare']; ?>"/>
                                </div>
                                <div class="formfieldcontentright">
                                    <?php foreach($tempcontent as $key) {
                                        if($key['contentName'] != 'childCare' || $key['comment'] == '') {  } else { ?>
                                            <input type="text" name="comment" class="loginitemcontentcomment" value="<?php echo $key['comment']; ?>"/>
                                    <?php }} ?>
                                </div>
                            </div>
                            
                            <?php 
                            $arrayLength = count($tempcontent);
                            for($i=0;$i<$arrayLength;$i++) {
                                if($tempcontent[$i]["comment"] == '') {
                                    $showSubmit = 'no';
                                }
                                else { $showSubmit = 'yes'; }
                            } 
                            if($showSubmit == 'no') { ?>
                                <div class="formfiedcontentcontainer">
                                    <div class="formfieldcontentmid">
                                         Er kan op dit moment nog niets gewizigd worden, een admin bekijkt uw vorige wijzigingen nog.
                                    </div>
                                </div>
                            ..
                            <?php } else { ?>
                                <?php echo '<a href="'.FRONTEND_LINK_ROOT.'" class="editpagecancel">ANNULEREN</a>'; ?>
                                <input style="cursor: pointer;" type="submit" name="updateSubmit" value="WIJZIGEN" class="editpagesubmit" />
                            <?php } ?>
                        </form>
                         ..
                    </div>
                </div>
                    <?php
                }
                elseif($pageStatus == 'uploadSucc') { ?>
                        <div class="schoolLogin1">
                            De informatie die u heeft gewijzigd is bewaard, er is een e-mail verzonden naar de beheerder, hij zal de informatie zo snel mogelijk bekijken en accepteren als het voldoet aan de eisen.
                            <br/> Klik hier <?php echo "<a href='".FRONTEND_LINK_ROOT."home'>here</a>";?> om terug te keren naar de homepage of wacht 5 seconden om automatisch doorverwezen te worden.                
                        </div>
                    <?php
                }
                elseif($pageStatus == 'authUnSucc') { ?>
                        <div class="schoolLogin1">
                            De login informatie die door u is ingevoerd is niet correct, probeer het opnieuw s.v.p.
                        </div>
                    <?php
                }
                elseif($pageStatus == 'uploadUnSucc') { ?> 
                        <div class="schoolLogin1">
                            De ingevulde informatie is niet bewaard, probeer het opnieuw s.v.p.
                        </div>
                    <?php
                }
                if($pageStatus == 'authSucc') {}
                else {
            ?>
            <div class="schoolLogin">
                <?php echo '<form action="" method="POST">'; ?>
                    <div id="logincontentleft">
                        <div class="logintitle">INLOGGEN</div>
                        <div class="loginitem">
                            <div class="loginitemtitle">BRIN:</div>
                            <input type="text" name="BRIN" class="loginitemcontent" />
                        </div>
                        <div class="loginitem">
                            <div class="loginitemtitle">E-MAIL:</div>
                            <input type="email" name="emailAddress" class="loginitemcontent" />
                        </div>
                        <input style="cursor: pointer;" type="submit" name="loginSubmit" value="GA DOOR" class="loginsubmit" />
                    </div>
                <?php echo '</form>'; }?>
            </div>
        </div>
    </body>
</html>