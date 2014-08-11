<?php 
   
//Designed and written in the year 2012, for ASG, by:
//Peter van Kleef, Richard Floris & Pepijn de Vries.
        
require_once MODEL_CRITERIA;
require_once MODEL_MENU;



    //Makes sure the user gets forwarded to the desired view.
    if($_POST["start"] == 'start'){
         header('Location: '.FRONTEND_LINK_ROOT.'home'); 
  
    }

?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <?php echo'<link rel="stylesheet" type="text/css" href="'.CSSF_HOME.'" />';
               echo'<link rel="stylesheet" type="text/css" href="'.CSSF_HEADER.'" />';
               echo'<link rel="stylesheet" type="text/css" href="'.CSSF_HELPTEXT.'" />'; 
               echo'<link rel="stylesheet" type="text/css" href="'.CSSF_DEFAULT.'" />'; ?>
        <!--[if IE]><link rel="stylesheet" type="text/css" href="../../_include/css/frontend/IEoverwrite.css"/><![endif]-->
        <title>SCHOOLINZICHT</title>
        <script type="text/javascript"> 

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
    <body class="body">
        <div id="header">
            <div id="headercontainer">      
                <?php include_once("views/components/frontendHeader.php"); ?>
            </div>
        </div>
        <div id="helptext">     
          
        </div>
        <div id="content">
            <form method="post" action="">
                <div id="stepheaderintro">
                  
                            <center><input type="submit" name="start" class="start" value="start" /></center>
                       
                    </div>
                    <div id="stepcolumnintro">
                         <center><b>Klik op de Startbutton om te beginnen. <br/>
Almere wenst u veel succes bij de zoektocht naar de juiste school voor uw kind(eren)!</b><br/></center>
                        <fieldset class="f5">Wat is Schoolinzicht Almere? </fieldset><br/>
                            
                        
                       <fieldset class="f6"> Schoolinzicht Almere geeft u als ouder inzicht in de kwaliteitsgegevens en prognoses van  basisscholen in Almere. <br/>Met behulp van Schoolinzicht Almere vindt u de school die het beste past bij uw kind(eren).<br/></fieldset><br/>
 <fieldset class="f5">Missie </fieldset><br/>
 <fieldset class="f6">De website heeft als missie ouders zo goed mogelijk te ondersteunen bij de zoektocht naar de beste school voor hun kind(eren). Op een onafhankelijke, overzichtelijke en toegankelijke wijze. <br/></fieldset><br/>
 <fieldset class="f5">Beschrijving </fieldset><br/>
<fieldset class="f6">Vanuit de Almeerse gemeenteraad is besloten dat er meer transparantie moet komen in de resultaten en prognoses van scholen in Almere. </br>

Op initiatief van het bestuur van de Almeerse Scholen Groep is om die reden in samenwerking met twee andere scholengroepen in Almere (Prisma en SKOFV) voor u de website Schoolinzichtalmere.nl ontwikkeld. <br/><br/>

De website geeft u als ouder inzicht in de kwaliteitsgegevens van alle basisscholen in Almere. <br/>Het gaat hier onder andere om gegevens als populatie, (tussentijdse) resultaten, oordeel onderwijsinspectie en nog meer.<br/><br/>

Schoolinzichtalmere.nl helpt u bij de zoektocht naar de best passende school voor hun kind(eren).<br/> Alle gegevens over de basisscholen binnen de website zijn objectief en worden gehaald uit administratie- of leerlingvolgsystemen waarmee de scholen werken.<br/> De scholen kunnen zelf bij onderdelen van de website nog een relevante context en toekomstvisie schetsen.<br/><br/>

Het doel is ouders zo goed mogelijk te ondersteunen bij de schoolkeuze d.m.v. het vrijgeven van onder andere resultaten, leerlingenaantallen en werkwijze.<br/> Schoolinzichtalmere.nl zorgt ervoor dat u  zich beter dan ooit kunt verdiepen in de schoolkeuze voor uw kind(eren).<br/><br/>
<b>Het wordt geadviseerd om de website in Firefox, Safari of Google chrome te gebruiken <br/></b>
</fieldset>


                        

                      
                    </div>
                
                </div>
               
                </div>
            </form>
            
        </div>
    </body>
</html> 