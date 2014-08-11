<?php
$pageName = 'FAQ';
//Designed and written in the year 2012, for ASG, by:
//Peter van Kleef, Richard Floris & Pepijn de Vries.

?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <?php echo'<link rel="stylesheet" type="text/css" href="'.CSSF_HOME.'" />';
               echo'<link rel="stylesheet" type="text/css" href="'.CSSF_HEADER.'" />';
               echo'<link rel="stylesheet" type="text/css" href="'.CSSF_HELPTEXT.'" />'; 
               echo'<link rel="stylesheet" type="text/css" href="'.CSSF_DEFAULT.'" />';
               echo'<link rel="stylesheet" type="text/css" href="'.CSSF_FAQ.'" />';?>
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
<?php include_once("views/components/infotext.php");
      ?></div>
<div id="content">
   <div id="faqleft">
    <div id="faqleftheader">FREQUENTLY ASKED QUESTIONS</div>
    <div id="faqleftcontent">
        <ul>
            <li class="faq">Waar kan ik aavullende gegevens over mijn school invoeren of wijzigen?</li>
          
        </ul>
    </div>
</div>
<div id="faqright">
    <div id="faqrightheader">FREQUENTLY ASKED QUESTIONS</div>
    <div id="faqrightcontent">
        <div class="faqitem">
            <div class="faqitemheader">Waar kan ik aavullende gegevens over mijn school invoeren of wijzigen?</div>
            <div class="faqitemcontent">
Onderaan de <a href="contact">contact</a> pagina is een link te vinden naar de <a href="schoolUpdate">school update pagina.</a></br>
Hier moet u inloggen met het BRIN nummer van uw school en het geregistreede email adres.
        </div>
        </div>
       
    </div>
</div>
</div>
          

    </body>
</html> 