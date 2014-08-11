<?php

//Designed and written in the year 2012, for ASG, by:
//Peter van Kleef, Richard Floris & Pepijn de Vries.

require_once MODEL_CRITERIA;
    $pageName = 'selSchoolMap';

$school = new Criteria;
$getFunction= 'getSchools'; 
//get all info of all schools:
$schoolcontent1 = $school->showItem($getFunction);  
//get the criteria from the URL:
$urlArray = explode('/',$_SERVER['REQUEST_URI']);
$urlParts = explode('=', $urlArray[2]);
//split the criteria:
$criteriaArray = explode('&', $urlParts[1]);
//define postcode and distance from this split:
$postcodeAfstand = explode('&', $urlParts[0]);
$postcode = $postcodeAfstand[0];
$afstand = $postcodeAfstand[1];

//define which page we are on (map or list):
$view = $urlArray[1];

//use the matchCriteriafunction to filter schools out:
$schoolcontent = $school->matchCriteria($criteriaArray, $schoolcontent1, $view, $postcode, $afstand);

$view = $urlArray[1];
      //Checks if the post values were from a selection or from a criteria update
    if(empty($_POST["postcode"]) && empty($_POST["afstand"]) && empty($_POST["students"])){}else{
        //puts all the criteriavalues into one string.
        foreach($_POST as $value){
           $criteriaValues =  $criteriaValues.$value;
        
        }
       
    }
//Delete Post when handled.     
 unset($_POST);
//if there are in fact criteria in the url:
if(!empty($criteriaValues)){
   header('Location: '.FRONTEND_LINK_ROOT.'selSchoolMap/'.$criteriaValues.'');    
    }

?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <?php echo'<link rel="stylesheet" type="text/css" href="'.CSSF_HOME.'" />';
               echo'<link rel="stylesheet" type="text/css" href="'.CSSF_HEADER.'" />';
               echo'<link rel="stylesheet" type="text/css" href="'.CSSF_HELPTEXT.'" />'; 
               echo'<link rel="stylesheet" type="text/css" href="'.CSSF_DEFAULT.'" />';
               echo'<link rel="stylesheet" type="text/css" href="'.CSSF_MAPVIEW.'" />';
        ?>
         <!--[if IE]><link rel="stylesheet" type="text/css" href="../../_include/css/frontend/IEoverwrite.css"/><![endif]-->
        <title>SCHOOLINZICHT</title>
        <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBbk0AyFqkUzGNUadSJKiKsVILxivUFZ-k&sensor=false"></script> 
        <?php echo '<script type="text/javascript" src="'.FRONTEND_LINK_ROOT.INCLUDES_PATH.'googlemaps.js"></script>'; ?>
        
    </head>
    <body class="body" onload="initialize()">
   
<div id="header">
    <div id="headercontainer">      
        <?php include_once("views/components/frontendHeader.php"); ?>
    </div>
</div>
<div id="helptext">     
    <?php include_once("views/components/infotext.php"); ?></div>
<div id="content">
    <div id="mapleft">
        <?php require_once('views/components/sideBar.php');  ?>
    </div> 
    <div id="mapright">
        <div id="maprighttop">
            <div id="maptabs">
            </div>
            <div id="mapvergelijken">
                <form method="POST" action="">
                    <?php echo'<p id = "p1"><a><img src="'.FRONTEND_IMAGES_PATH.'vergelijkengrey.png" alt="" class="imageMap" /></a></p>' ;?>
                </form>
            </div>
        </div>
        <div id="maprightcontent">
            <div id="map_canvas">
            </div>
        </div>
    </div>
</div>
    </body>
</html> 
<script> var root = "<?php echo FRONTEND_LINK_ROOT;?>";</script>