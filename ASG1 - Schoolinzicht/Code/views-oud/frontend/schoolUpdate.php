<?php 

//Designed and written in the year 2012, for ASG, by:
//Peter van Kleef, Richard Floris & Pepijn de Vries.

require_once MODEL_SCHOOL;
require_once MODEL_HIGHCHARTS;
    $pageName = 'schoolUpdate';

$check = new School;

$switchID = 'schoolupdate';
$charts = new highCharts;


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
    echo $pageStatus;
}

if($pageStatus == 'authSucc') {
    $getFunction = 'getFrontendSchool';
    $contenttoshow = new BaseModel;
    $content = $contenttoshow->showItem($getFunction, $_POST['BRIN']);
    $getFunction = 'getTabContexts';
    $context = $contenttoshow->showItem($getFunction, $_POST['BRIN']);
    $getFunction = 'getTempData';
    $tempcontent = $contenttoshow->showItem($getFunction, $_POST['BRIN']);
    $i=1;
    foreach($context as $value) {
        $content[0]['context'.$i] = $value['context'];
        $i++;
    }
    foreach($tempcontent as $value) {
        $content[0][$value["contentName"]] = $value["content"];
    } 
    $arrayLength = count($tempcontent);
    if($arrayLength == '0') {
        $showSubmit = 'yes';
    }
    else {
        for($i=0;$i<$arrayLength;$i++) {
            if($tempcontent[$i]["comment"] == '') {
                $showSubmit = 'no';
            }
            else { $showSubmit = 'yes'; }
        } 
    }
}
if($showSubmit == 'no') {
    $errorMessage = 'Er kan op dit moment nog niets gewijzigd worden, een admin bekijkt uw vorige wijzigingen nog.';
}
if($pageStatus == 'uploadSucc') {
    $errorMessage = 'De informatie die u heeft gewijzigd is bewaard, er is een e-mail verzonden naar de beheerder en naar u.<br/> Klik <a href="">hier</a> om terug te keren naar de homepage of wacht 5 seconden om automatisch doorverwezen te worden.';
}
if($pageStatus == 'uploadUnSucc') {
    $errorMessage = 'De ingevulde informatie is niet bewaard, probeer het opnieuw s.v.p.';
}
if ($pageStatus == 'authUnSucc') {
    $errorMessage = 'De login informatie die door u is ingevoerd is niet correct, probeer het opnieuw s.v.p.';
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
        <!--[if IE]><link rel="stylesheet" type="text/css" href="../../_include/css/frontend/IEoverwrite.css"/><![endif]-->
        <?php if($pageStatus == 'uploadSucc') { echo '<meta http-equiv="refresh" content="8; URL='.FRONTEND_LINK_ROOT.'home">'; } else { } ?>
        <title>SCHOOLINZICHT</title>
        <script language="javascript">
            function toggleContext(divID) {
                var ele = document.getElementById(divID);
                if(ele.style.display == "block") {
                    ele.style.display = "none";
                }
                else {
                    ele.style.display = "block";
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
        <div id="header">
            <div id="headercontainer">      
                <?php include_once("views/components/frontendHeader.php"); ?>
            </div>
        </div>
        <div id="helptext">     
            <?php include_once("views/components/infotext.php"); ?>
        </div>
        <form action="" method="POST" ENCTYPE="multipart/form-data">
            <?php if($showSubmit == 'yes') { ?>
                <div id="floatingDiv">
                    <input style="cursor: pointer;" type="submit" name="updateSubmit" value="OPSLAAN" class="editpagesubmit" />
                    <?php echo '<a href="'.FRONTEND_LINK_ROOT.'" class="editpagecancel">ANNULEREN</a>'; ?>
                </div>
            <?php } else {} if($errorMessage != '') { ?>
                <div id="floatingError"><?php echo $errorMessage; ?></div>
            <?php } ?>
        <div id="content">
            <?php 
                if($pageStatus == 'authSucc') { ?>
                 <div class="schoolLogin">
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
                                <div class="loginitemtitle">Foto:</div>
                                <input type="file" name="logoPath" class="loginitemcontentFile"/>
                            </div>
                            <div class="formfieldcontentright">
                                <?php if(empty($tempcontent)) { ?><input type="text" name="comment" class="loginitemcontentcomment" value="LET OP, DIT MOET EEN PNG ZIJN"/><?php } ?>

                            </div>
                        </div>
                        <div class="formfieldcontentcontainer">
                            <div class="formfieldcontentmid">
                                <div class="loginitemtitleLong">Naschoolse opvang:</div>
                                <select name="childCare" class="loginitemcontentShort">
                                    <?php if($content[0]['childCare'] == 'Geen') {?>
                                        <option>Geen</option>
                                        <option>Aanwezig</option>
                                    <?php } else { ?>
                                        <option>Aanwezig</option>
                                        <option>Geen</option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="formfieldcontentright">
                                <?php foreach($tempcontent as $key) {
                                    if($key['contentName'] != 'childCare' || $key['comment'] == '') {  } else { ?>
                                        <input type="text" name="comment" class="loginitemcontentcomment" value="<?php echo $key['comment']; ?>"/>
                                <?php }} ?>
                            </div>
                        </div>
                        <div class="formfieldcontentcontainer">
                            <div class="formfieldcontentmid">
                                <div class="loginitemtitleLonger">Directieleden:</div>
                                <input type="text" name="directieleden" class="loginitemcontentShorter"  Value="<?php  echo $content[0]['directieleden']; ?>"/>
                            </div>
                            <div class="formfieldcontentright">
                                <?php foreach($tempcontent as $key) {
                                    if($key['contentName'] != 'directieleden' || $key['comment'] == '') {  } else { ?>
                                        <input type="text" name="comment" class="loginitemcontentcomment" value="<?php echo $key['comment']; ?>"/>
                                <?php }} ?>
                            </div>
                        </div>
                        <div class="formfieldcontentcontainer">
                            <div class="formfieldcontentmid">
                                <div class="loginitemtitleLonger">Directieleden (FTE):</div>
                                <input type="text" name="directieledenFTE" class="loginitemcontentShorter"  Value="<?php  echo $content[0]['directieledenFTE']; ?>"/>
                            </div>
                            <div class="formfieldcontentright">
                                <?php foreach($tempcontent as $key) {
                                    if($key['contentName'] != 'directieledenFTE' || $key['comment'] == '') {  } else { ?>
                                        <input type="text" name="comment" class="loginitemcontentcomment" value="<?php echo $key['comment']; ?>"/>
                                <?php }} ?>
                            </div>
                        </div>
                        <div class="formfieldcontentcontainer">
                            <div class="formfieldcontentmid">
                                <div class="loginitemtitleLonger">Onderwijzend Personeel:</div>
                                <input type="text" name="onderwijzendPersoneel" class="loginitemcontentShorter"  Value="<?php  echo $content[0]['onderwijzendPersoneel']; ?>"/>
                            </div>
                            <div class="formfieldcontentright">
                                <?php foreach($tempcontent as $key) {
                                    if($key['contentName'] != 'onderwijzendPersoneel' || $key['comment'] == '') {  } else { ?>
                                        <input type="text" name="comment" class="loginitemcontentcomment" value="<?php echo $key['comment']; ?>"/>
                                <?php }} ?>
                            </div>
                        </div>
                        <div class="formfieldcontentcontainer">
                            <div class="formfieldcontentmid">
                                <div class="loginitemtitleLonger">Onderwijzend Personeel (FTE):</div>
                                <input type="text" name="onderwijzendPersoneelFTE" class="loginitemcontentShorter"  Value="<?php  echo $content[0]['onderwijzendPersoneelFTE']; ?>"/>
                            </div>
                            <div class="formfieldcontentright">
                                <?php foreach($tempcontent as $key) {
                                    if($key['contentName'] != 'onderwijzendPersoneelFTE' || $key['comment'] == '') {  } else { ?>
                                        <input type="text" name="comment" class="loginitemcontentcomment" value="<?php echo $key['comment']; ?>"/>
                                <?php }} ?>
                            </div>
                        </div>
                        <div class="formfieldcontentcontainer">
                            <div class="formfieldcontentmid">
                                <div class="loginitemtitleLonger">Ondersteunend Personeel:</div>
                                <input type="text" name="onderwijsOndersteunendPersoneel" class="loginitemcontentShorter"  Value="<?php  echo $content[0]['onderwijsOndersteunendPersoneel']; ?>"/>
                            </div>
                            <div class="formfieldcontentright">
                                <?php foreach($tempcontent as $key) {
                                    if($key['contentName'] != 'onderwijsOndersteunendPersoneel' || $key['comment'] == '') {  } else { ?>
                                        <input type="text" name="comment" class="loginitemcontentcomment" value="<?php echo $key['comment']; ?>"/>
                                <?php }} ?>
                            </div>
                        </div>
                        <div class="formfieldcontentcontainer">
                            <div class="formfieldcontentmid">
                                <div class="loginitemtitleLonger">Ondersteunend Personeel (FTE):</div>
                                <input type="text" name="onderwijsOndersteunendPersoneelFTE" class="loginitemcontentShorter"  Value="<?php  echo $content[0]['onderwijsOndersteunendPersoneelFTE']; ?>"/>
                            </div>
                            <div class="formfieldcontentright">
                                <?php foreach($tempcontent as $key) {
                                    if($key['contentName'] != 'onderwijsOndersteunendPersoneelFTE' || $key['comment'] == '') {  } else { ?>
                                        <input type="text" name="comment" class="loginitemcontentcomment" value="<?php echo $key['comment']; ?>"/>
                                <?php }} ?>
                            </div>
                        </div>
                        <div class="formfieldcontentcontainer">
                            <div class="formfieldcontentmid">
                                <div class="loginitemtitleLonger">Aant. man. werknemers:</div>
                                <input type="text" name="mannen" class="loginitemcontentShorter"  Value="<?php  echo $content[0]['mannen']; ?>"/>
                            </div>
                            <div class="formfieldcontentright">
                                <?php foreach($tempcontent as $key) {
                                    if($key['contentName'] != 'mannen' || $key['comment'] == '') {  } else { ?>
                                        <input type="text" name="comment" class="loginitemcontentcomment" value="<?php echo $key['comment']; ?>"/>
                                <?php }} ?>
                            </div>
                        </div>
                        <div class="formfieldcontentcontainer">
                            <div class="formfieldcontentmid">
                                <div class="loginitemtitleLonger">Aant. man. werknemers (FTE):</div>
                                <input type="text" name="mannenFTE" class="loginitemcontentShorter"  Value="<?php  echo $content[0]['mannenFTE']; ?>"/>
                            </div>
                            <div class="formfieldcontentright">
                                <?php foreach($tempcontent as $key) {
                                    if($key['contentName'] != 'mannenFTE' || $key['comment'] == '') {  } else { ?>
                                        <input type="text" name="comment" class="loginitemcontentcomment" value="<?php echo $key['comment']; ?>"/>
                                <?php }} ?>
                            </div>
                        </div>
                        <div class="formfieldcontentcontainer">
                            <div class="formfieldcontentmid">
                                <div class="loginitemtitleLonger">Aant. vrouw. werknemers:</div>
                                <input type="text" name="vrouwen" class="loginitemcontentShorter"  Value="<?php  echo $content[0]['vrouwen']; ?>"/>
                            </div>
                            <div class="formfieldcontentright">
                                <?php foreach($tempcontent as $key) {
                                    if($key['contentName'] != 'vrouwen' || $key['comment'] == '') {  } else { ?>
                                        <input type="text" name="comment" class="loginitemcontentcomment" value="<?php echo $key['comment']; ?>"/>
                                <?php }} ?>
                            </div>
                        </div>
                        <div class="formfieldcontentcontainer">
                            <div class="formfieldcontentmid">
                                <div class="loginitemtitleLonger">Aant. vrouw. werknemers (FTE):</div>
                                <input type="text" name="vrouwenFTE" class="loginitemcontentShorter"  Value="<?php  echo $content[0]['vrouwenFTE']; ?>"/>
                            </div>
                            <div class="formfieldcontentright">
                                <?php foreach($tempcontent as $key) {
                                    if($key['contentName'] != 'vrouwenFTE' || $key['comment'] == '') {  } else { ?>
                                        <input type="text" name="comment" class="loginitemcontentcomment" value="<?php echo $key['comment']; ?>"/>
                                <?php }} ?>
                            </div>
                        </div>
                        <div class="formfieldcontentcontainer">
                            <div class="formfieldcontentmid">
                                <div class="loginitemtitleLonger">Percentage Ziekteverzuim:</div>
                                <input type="text" name="ziekteverzuim" class="loginitemcontentShorter"  Value="<?php  echo $content[0]['ziekteverzuim']; ?>"/>
                            </div>
                            <div class="formfieldcontentright">
                                <?php foreach($tempcontent as $key) {
                                    if($key['contentName'] != 'ziekteverzuim' || $key['comment'] == '') {  } else { ?>
                                        <input type="text" name="comment" class="loginitemcontentcomment" value="<?php echo $key['comment']; ?>"/>
                                <?php }} ?>
                            </div>
                        </div>
                        <div class="formfieldcontentcontainer">
                            <div class="formfieldcontentmidGraph">
                                <div class="loginitemtitleLonger">Tabblad 1 Populatie:</div>
                                <div class="graphfield">
                                    <?php $schoolGraph=1; $selectedTab = '1'; $selectedSchool = $_POST['BRIN'];
                                    $charts->generateGraph($switchID, $selectedTab, $selectedSchool, $schoolGraph);?>
                                </div>
                            </div>
                            <div class="formfieldcontentright">
                                <?php foreach($tempcontent as $key) {
                                    if($key['contentName'] != 'context1' || $key['comment'] == '') {  } else { ?>
                                        <input type="text" name="comment" class="loginitemcontentcomment" value="<?php echo $key['comment']; ?>"/>
                                <?php }} ?>
                            </div>
                        </div>
                        <div id="tabcontextOff1" class="formfieldcontentcontainer">
                            <div class="formfieldcontentmidContext">
                                <?php if(isset($content[0]['context1'])) { $input1 = 'CHECKED'; $input2 = ''; } else { $input1 = ''; $input2 = 'CHECKED'; } ?>
                                <div class="loginitemtitleOnOff">
                                    CONTEXT&nbsp;&nbsp;<input type="radio" name="test1" value="yes" onchange="toggleContext('tabcontextOn1')" <?php echo $input1; ?>/>JA
                                    &nbsp;&nbsp;<input type="radio" name="test1" value="no" onchange="toggleContext('tabcontextOn1')" <?php echo $input2; ?>/>NEE
                                </div>
                            </div>
                            <div class="formfieldcontentright">
                            </div>
                        </div>
                            <?php if(isset($content[0]['context1'])) { $display = 'style="display:block"'; } else { $display = 'style="display:none"'; } ?>
                        <div id="tabcontextOn1" <?php echo $display; ?> class="formfieldcontentcontainer" >
                            <div class="formfieldcontentmidContext">
                                <textarea name="context1" class="contextfield"><?php echo $content[0]['context1']; ?></textarea>
                            </div>
                            <div class="formfieldcontentright">
                                <?php foreach($tempcontent as $key) {
                                    if($key['contentName'] != 'context1' || $key['comment'] == '') {  } else { ?>
                                        <input type="text" name="comment" class="loginitemcontentcommentTab" value="<?php echo $key['comment']; ?>"/>
                                <?php }} ?>
                            </div>
                        </div>
                            
                        <div class="formfieldcontentcontainer">
                            <div class="formfieldcontentmidGraph">
                                <div class="loginitemtitleLonger">Tabblad 2 Prognose:</div>
                                <div class="graphfield">
                                    <?php $schoolGraph=1; $selectedTab = '2'; $selectedSchool = $_POST['BRIN'];
                                    $charts->generateGraph($switchID, $selectedTab, $selectedSchool, $schoolGraph);?>
                                </div>
                            </div>
                            <div class="formfieldcontentright">
                                <?php foreach($tempcontent as $key) {
                                    if($key['contentName'] != 'context2' || $key['comment'] == '') {  } else { ?>
                                        <input type="text" name="comment" class="loginitemcontentcomment" value="<?php echo $key['comment']; ?>"/>
                                <?php }} ?>
                            </div>
                        </div>
                        <div id="tabcontextOff2" class="formfieldcontentcontainer">
                            <div class="formfieldcontentmidContext">
                                <?php if(isset($content[0]['context2'])) { $input1 = 'CHECKED'; $input2 = ''; } else { $input1 = ''; $input2 = 'CHECKED'; } ?>
                                <div class="loginitemtitleOnOff">
                                    CONTEXT&nbsp;&nbsp;<input type="radio" name="test2" value="yes" onchange="toggleContext('tabcontextOn2')" <?php echo $input1; ?>/>JA
                                    &nbsp;&nbsp;<input type="radio" name="test2" value="no" onchange="toggleContext('tabcontextOn2')" <?php echo $input2; ?>/>NEE
                                </div>
                            </div>
                            <div class="formfieldcontentright">
                            </div>
                        </div>
                            <?php if(isset($content[0]['context2'])) { $display = 'style="display:block"'; } else { $display = 'style="display:none"'; } ?>
                        <div id="tabcontextOn2" <?php echo $display; ?> class="formfieldcontentcontainer" >
                            <div class="formfieldcontentmidContext">
                                <textarea name="context2" class="contextfield"><?php echo $content[0]['context2']; ?></textarea>
                            </div>
                            <div class="formfieldcontentright">
                                <?php foreach($tempcontent as $key) {
                                    if($key['contentName'] != 'context2' || $key['comment'] == '') {  } else { ?>
                                        <input type="text" name="comment" class="loginitemcontentcommentTab" value="<?php echo $key['comment']; ?>"/>
                                <?php }} ?>
                            </div>
                        </div> 
                            
                        <div class="formfieldcontentcontainer">
                            <div class="formfieldcontentmidGraph">
                                <div class="loginitemtitleLonger">Tabblad 3 Tussenopbrengsten:</div>
                                <div class="graphfield">
                                    <?php $schoolGraph=1; $selectedTab = '3'; $selectedSchool = $_POST['BRIN'];
                                    $charts->generateGraph($switchID, $selectedTab, $selectedSchool, $schoolGraph);?>
                                </div>
                            </div>
                            <div class="formfieldcontentright">
                                <?php foreach($tempcontent as $key) {
                                    if($key['contentName'] != 'context3' || $key['comment'] == '') {  } else { ?>
                                        <input type="text" name="comment" class="loginitemcontentcomment" value="<?php echo $key['comment']; ?>"/>
                                <?php }} ?>
                            </div>
                        </div>
                        <div id="tabcontextOff3" class="formfieldcontentcontainer">
                            <div class="formfieldcontentmidContext">
                                <?php if(isset($content[0]['context3'])) { $input1 = 'CHECKED'; $input2 = ''; } else { $input1 = ''; $input2 = 'CHECKED'; } ?>
                                <div class="loginitemtitleOnOff">
                                    CONTEXT&nbsp;&nbsp;<input type="radio" name="test3" value="yes" onchange="toggleContext('tabcontextOn3')" <?php echo $input1; ?>/>JA
                                    &nbsp;&nbsp;<input type="radio" name="test3" value="no" onchange="toggleContext('tabcontextOn3')" <?php echo $input2; ?>/>NEE
                                </div>
                            </div>
                            <div class="formfieldcontentright">
                            </div>
                        </div>
                            <?php if(isset($content[0]['context3'])) { $display = 'style="display:block"'; } else { $display = 'style="display:none"'; } ?>
                        <div id="tabcontextOn3" <?php echo $display; ?> class="formfieldcontentcontainer" >
                            <div class="formfieldcontentmidContext">
                                <textarea name="context3" class="contextfield"><?php echo $content[0]['context3']; ?></textarea>
                            </div>
                            <div class="formfieldcontentright">
                                <?php foreach($tempcontent as $key) {
                                    if($key['contentName'] != 'context3' || $key['comment'] == '') {  } else { ?>
                                        <input type="text" name="comment" class="loginitemcontentcommentTab" value="<?php echo $key['comment']; ?>"/>
                                <?php }} ?>
                            </div>
                        </div> 
                            
                        <div class="formfieldcontentcontainer">
                            <div class="formfieldcontentmidGraph">
                                <div class="loginitemtitleLonger">Tabblad 4 Cito Eindtoets:</div>
                                <div class="graphfield">
                                    <?php $schoolGraph=1; $selectedTab = '4'; $selectedSchool = $_POST['BRIN'];
                                    $charts->generateGraph($switchID, $selectedTab, $selectedSchool, $schoolGraph);?>
                                </div>
                            </div>
                            <div class="formfieldcontentright">
                                <?php foreach($tempcontent as $key) {
                                    if($key['contentName'] != 'context4' || $key['comment'] == '') {  } else { ?>
                                        <input type="text" name="comment" class="loginitemcontentcomment" value="<?php echo $key['comment']; ?>"/>
                                <?php }} ?>
                            </div>
                        </div>
                        <div id="tabcontextOff4" class="formfieldcontentcontainer">
                            <div class="formfieldcontentmidContext">
                                <?php if(isset($content[0]['context4'])) { $input1 = 'CHECKED'; $input2 = ''; } else { $input1 = ''; $input2 = 'CHECKED'; } ?>
                                <div class="loginitemtitleOnOff">
                                    CONTEXT&nbsp;&nbsp;<input type="radio" name="test4" value="yes" onchange="toggleContext('tabcontextOn4')" <?php echo $input1; ?>/>JA
                                    &nbsp;&nbsp;<input type="radio" name="test4" value="no" onchange="toggleContext('tabcontextOn4')" <?php echo $input2; ?>/>NEE
                                </div>
                            </div>
                            <div class="formfieldcontentright">
                            </div>
                        </div>
                            <?php if(isset($content[0]['context4'])) { $display = 'style="display:block"'; } else { $display = 'style="display:none"'; } ?>
                        <div id="tabcontextOn4" <?php echo $display; ?> class="formfieldcontentcontainer" >
                            <div class="formfieldcontentmidContext">
                                <textarea name="context4" class="contextfield"><?php echo $content[0]['context4']; ?></textarea>
                            </div>
                            <div class="formfieldcontentright">
                                <?php foreach($tempcontent as $key) {
                                    if($key['contentName'] != 'context4' || $key['comment'] == '') {  } else { ?>
                                        <input type="text" name="comment" class="loginitemcontentcommentTab" value="<?php echo $key['comment']; ?>"/>
                                <?php }} ?>
                            </div>
                        </div> 
                            
                        <div class="formfieldcontentcontainer">
                            <div class="formfieldcontentmidGraph">
                                <div class="loginitemtitleLonger">Tabblad 5 Adviezen PO:</div>
                                <div class="graphfield">
                                    <?php $schoolGraph=1; $selectedTab = '5'; $selectedSchool = $_POST['BRIN'];
                                    $charts->generateGraph($switchID, $selectedTab, $selectedSchool, $schoolGraph);?>
                                </div>
                            </div>
                            <div class="formfieldcontentright">
                                <?php foreach($tempcontent as $key) {
                                    if($key['contentName'] != 'context5' || $key['comment'] == '') {  } else { ?>
                                        <input type="text" name="comment" class="loginitemcontentcomment" value="<?php echo $key['comment']; ?>"/>
                                <?php }} ?>
                            </div>
                        </div>
                        <div id="tabcontextOff5" class="formfieldcontentcontainer">
                            <div class="formfieldcontentmidContext">
                                <?php if(isset($content[0]['context5'])) { $input1 = 'CHECKED'; $input2 = ''; } else { $input1 = ''; $input2 = 'CHECKED'; } ?>
                                <div class="loginitemtitleOnOff">
                                    CONTEXT&nbsp;&nbsp;<input type="radio" name="test5" value="yes" onchange="toggleContext('tabcontextOn5')" <?php echo $input1; ?>/>JA
                                    &nbsp;&nbsp;<input type="radio" name="test5" value="no" onchange="toggleContext('tabcontextOn5')" <?php echo $input2; ?>/>NEE
                                </div>
                            </div>
                            <div class="formfieldcontentright">
                            </div>
                        </div>
                            <?php if(isset($content[0]['context5'])) { $display = 'style="display:block"'; } else { $display = 'style="display:none"'; } ?>
                        <div id="tabcontextOn5" <?php echo $display; ?> class="formfieldcontentcontainer" >
                            <div class="formfieldcontentmidContext">
                                <textarea name="context5" class="contextfield"><?php echo $content[0]['context5']; ?></textarea>
                            </div>
                            <div class="formfieldcontentright">
                                <?php foreach($tempcontent as $key) {
                                    if($key['contentName'] != 'context5' || $key['comment'] == '') {  } else { ?>
                                        <input type="text" name="comment" class="loginitemcontentcommentTab" value="<?php echo $key['comment']; ?>"/>
                                <?php }} ?>
                            </div>
                        </div> 
                            
                        <div class="formfieldcontentcontainer">
                            <div class="formfieldcontentmidGraph">
                                <div class="loginitemtitleLonger">Tabblad 6 Inspectie Oordeel:</div>
                                <div class="graphfield">
                                    <?php $schoolGraph=1; $selectedTab = '6'; $selectedSchool = $_POST['BRIN'];
                                    $charts->generateGraph($switchID, $selectedTab, $selectedSchool, $schoolGraph);?>
                                </div>
                            </div>
                            <div class="formfieldcontentright">
                                <?php foreach($tempcontent as $key) {
                                    if($key['contentName'] != 'context6' || $key['comment'] == '') {  } else { ?>
                                        <input type="text" name="comment" class="loginitemcontentcomment" value="<?php echo $key['comment']; ?>"/>
                                <?php }} ?>
                            </div>
                        </div>
                        <div id="tabcontextOff6" class="formfieldcontentcontainer">
                            <div class="formfieldcontentmidContext">
                                <?php if(isset($content[0]['context6'])) { $input1 = 'CHECKED'; $input2 = ''; } else { $input1 = ''; $input2 = 'CHECKED'; } ?>
                                <div class="loginitemtitleOnOff">
                                    CONTEXT&nbsp;&nbsp;<input type="radio" name="test6" value="yes" onchange="toggleContext('tabcontextOn6')" <?php echo $input1; ?>/>JA
                                    &nbsp;&nbsp;<input type="radio" name="test6" value="no" onchange="toggleContext('tabcontextOn6')" <?php echo $input2; ?>/>NEE
                                </div>
                            </div>
                            <div class="formfieldcontentright">
                            </div>
                        </div>
                            <?php if(isset($content[0]['context6'])) { $display = 'style="display:block"'; } else { $display = 'style="display:none"'; } ?>
                        <div id="tabcontextOn6" <?php echo $display; ?> class="formfieldcontentcontainer" >
                            <div class="formfieldcontentmidContext">
                                <textarea name="context6" class="contextfield"><?php echo $content[0]['context6']; ?></textarea>
                            </div>
                            <div class="formfieldcontentright">
                                <?php foreach($tempcontent as $key) {
                                    if($key['contentName'] != 'context6' || $key['comment'] == '') {  } else { ?>
                                        <input type="text" name="comment" class="loginitemcontentcommentTab" value="<?php echo $key['comment']; ?>"/>
                                <?php }} ?>
                            </div>
                        </div>  
                            
                                 <div class="formfieldcontentcontainer">
                            <div class="formfieldcontentmidGraph">
                                <div class="loginitemtitleLonger">Tabblad 7 Bedrijfskundige Info:</div>
                                <div class="graphfield">
                                    <?php $schoolGraph=1; $selectedTab = '7'; $selectedSchool = $_POST['BRIN'];
                                    $charts->generateGraph($switchID, $selectedTab, $selectedSchool, $schoolGraph);?>
                                </div>
                            </div>
                            <div class="formfieldcontentright">
                                <?php foreach($tempcontent as $key) {
                                    if($key['contentName'] != 'context7' || $key['comment'] == '') {  } else { ?>
                                        <input type="text" name="comment" class="loginitemcontentcomment" value="<?php echo $key['comment']; ?>"/>
                                <?php }} ?>
                            </div>
                        </div>
                        <div id="tabcontextOff7" class="formfieldcontentcontainer">
                            <div class="formfieldcontentmidContext">
                                <?php if(isset($content[0]['context7'])) { $input1 = 'CHECKED'; $input2 = ''; } else { $input1 = ''; $input2 = 'CHECKED'; } ?>
                                <div class="loginitemtitleOnOff">
                                    CONTEXT&nbsp;&nbsp;<input type="radio" name="test7" value="yes" onchange="toggleContext('tabcontextOn7')" <?php echo $input1; ?>/>JA
                                    &nbsp;&nbsp;<input type="radio" name="test7" value="no" onchange="toggleContext('tabcontextOn7')" <?php echo $input2; ?>/>NEE
                                </div>
                            </div>
                            <div class="formfieldcontentright">
                            </div>
                        </div>
                            <?php if(isset($content[0]['context7'])) { $display = 'style="display:block"'; } else { $display = 'style="display:none"'; } ?>
                        <div id="tabcontextOn7" <?php echo $display; ?> class="formfieldcontentcontainer" >
                            <div class="formfieldcontentmidContext">
                                <textarea name="context7" class="contextfield"><?php echo $content[0]['context7']; ?></textarea>
                            </div>
                            <div class="formfieldcontentright">
                                <?php foreach($tempcontent as $key) {
                                    if($key['contentName'] != 'context7' || $key['comment'] == '') {  } else { ?>
                                        <input type="text" name="comment" class="loginitemcontentcommentTab" value="<?php echo $key['comment']; ?>"/>
                                <?php }} ?>
                            </div>
                        </div> 
                    </form>
                     ...
                 </div>
               <?php } else { ?>
                    <div class="schoolLogin">
                        <?php echo '<form action="" method="POST">'; ?>
                            <div id="logincontentleft">
                                <div class="logintitle">INLOGGEN</div>
                                <div class="loginitem">
                                    <div class="loginitemtitle">Gebruikersnaam:</div>
                                    <input type="text" name="BRIN" class="loginitemcontent" />
                                </div>
                                <div class="loginitem">
                                    <div class="loginitemtitle">Wachtwoord:</div>
                                    <input type="email" name="emailAddress" class="loginitemcontent" />
                                </div>
                                <input style="cursor: pointer;" type="submit" name="loginSubmit" value="GA DOOR" class="loginsubmit" />
                            </div>
                        <?php echo '</form>'; ?>
                    </div>
            <?php } ?>
        </div>
    </body>
</html>