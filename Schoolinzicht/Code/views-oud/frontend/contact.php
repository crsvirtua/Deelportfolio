<?php

//Designed and written in the year 2012, for ASG, by:
//Peter van Kleef, Richard Floris & Pepijn de Vries.

require_once MODEL_CRITERIA;
    $pageName = 'contact';

$getContent = new BaseModel;
$getFunction = 'getPageID';
$pageName = 'Contact';
$pageID = $getContent->showItem($getFunction, $pageName);
$getFunction = 'getContactInfo';
$contactinfo = $getContent->showItem($getFunction, $pageID[0]['pageID']);
foreach($contactinfo as $value) {
    if($value['categoryName'] == 'algemeneInfo') { 
        $algemeenTitle = $value['title'];
        $algemeenBody = $value['body'];
    }
    elseif($value['categoryName'] == 'projectCredits') {
        $projectcreditsTitle = $value['title'];
        $projectcreditsBody = $value['body'];
    }
}
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <?php echo'<link rel="stylesheet" type="text/css" href="'.CSSF_HOME.'" />';
               echo'<link rel="stylesheet" type="text/css" href="'.CSSF_HEADER.'" />';
               echo'<link rel="stylesheet" type="text/css" href="'.CSSF_HELPTEXT.'" />'; 
               echo'<link rel="stylesheet" type="text/css" href="'.CSSF_DEFAULT.'" />';
               echo'<link rel="stylesheet" type="text/css" href="'.CSSF_CONTACT.'" />';?>
        <!--[if IE]><link rel="stylesheet" type="text/css" href="../../_include/css/frontend/IEoverwrite.css"/><![endif]-->
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
            <div id="contactleft">
                <div id="contactintroduction">
                    <div class="contactheader">
                        <?php echo $algemeenTitle; ?>
                    </div>
                    <div class="contacttext">
                        <?php echo $algemeenBody; ?>
                    </div>
                </div>
                <div class="contactcredits">
                    <div class="contactheader">
                        <?php echo $projectcreditsTitle; ?>
                    </div>
                    <div class="contacttext">
                        <?php echo $projectcreditsBody; ?>
                    </div>
                </div>
                <div class="contactcredits">
                </div>
            </div>
            <div id="contactright">
               <div id="contactform">
               <div class="contactheader">
                        Informatie over uw school beheren
                    </div>
                    <div class="contacttext">
                        Als beheerder van uw school kunt u via deze link uw informatie beheren:
                        <br/><br/>
                        <a href="schoolUpdate">UPDATE PAGINA VOOR SCHOLEN</a>
                    </div>
  <!--                   <div class="contactheader">
                        Neem contact op
                    </div>
                    <div id="formtext">
                        <div class="contactformtext">uw e-mailadres:</div>
                        <div class="contactformtext">uw naam:</div>
                        <div class="contactformtext">verzenden aan:</div>
                        <div class="contactformtext">onderwerp:</div>
                        <div class="contactformtext">uw bericht:</div>
                    </div>
                    <div id="contactformfield">
                        <form method="post" action="index.php?p=contact">
                            <input name="emailaddress" type="text" class="contactforminput" />
                            <input name="name" type="text" class="contactforminput" />
                            <input name="messageto" type="text" class="contactforminput" />
                            <input name="subject" type="text" class="contactforminput" />
                            <input name="message" type="text" class="contactforminputlong" />
                            <input type="submit" value="VERZENDEN" class="formsubmit" />
                        </form>
                    </div>
-->                </div>
<!-- Nieuwsbrief inschrijving disabled
                <div id="contactnewsletter">
                    <div class="contactheader">
                        Schrijf u in voor de nieuwsbrief
                    </div>
                    <div id="formtext">
                        <div class="contactformtext">uw e-mailadres:</div>
                        <div class="contactformtext">uw naam:</div>
                    </div>
                    <div id="contactformfield">
                        <form method="post" action="index.php?p=contact">
                            <input name="emailaddress" type="text" class="contactforminput" />
                            <input name="name" type="text" class="contactforminput" />
                            <input type="submit" value="VERZENDEN" class="formsubmit" />
                        </form>
                    </div>              
                </div> 
-->
            </div>
        </div>
    </body>
</html>