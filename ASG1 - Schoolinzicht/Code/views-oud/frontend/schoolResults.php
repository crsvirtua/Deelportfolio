<?php
$pageName = 'schoolResults';
//Designed and written in the year 2012, for ASG, by:
//Peter van Kleef, Richard Floris & Pepijn de Vries.
?>

<?php
require_once MODEL_HIGHCHARTS;
require_once MODEL_SCHOOL;
require_once MODEL_CRITERIA;
require_once MODEL_MENU;
//removes the / from the URL given from the SchoolList and puts the values in an array, to identify which school and tab is selected.
  $idArray = explode('/', $_SERVER['REQUEST_URI']); 
 // print_r($idArray);
  $selectedSchool = $idArray[2];
  $selectedTab = $idArray[3];

    // $id = $idArray[2];
    //$sorting= '1';
  
  //makes sure the tab will always be set to the first one if no tabs are selected
  if($selectedTab == 0){
      $selectedTab = 1;
  }
  
  $switchID='profile';

   
//Test Values
//06RM00 Raphael
//23ZX00  Polygoon
//21ND00  Duizendpoot


//Gets the school, context and tabs from the basemodel and querymanager
$school = new school;
$getFunction = 'getSchool';
$schoolInfo = $school->showItem($getFunction, $selectedSchool);
$getFunction = 'getContext';
$schoolContext = $school->showItem($getFunction, $selectedSchool);
$getFunction = 'getTabs';
$schoolTabs = $school->showItems($getFunction);

$getFunction = 'getStudentTotal';
// get the current year and detract 2 to get the desired year from the DB
$today = date("Y");     
$year = $today - 1;
$totalStudents = $school->showItem($getFunction, $selectedSchool, $year);

//Counts the number of tabs retrieved from the database for the while loop at the tabs section.
$schoolTabsCount = count($schoolTabs);

//print_r($schoolContext);
/*print_r($schoolInfo);/*
 * 
echo '- - - - - - - - - - - onderbreking - - - - - - -';

echo '- - - - - - - - - - - onderbreking - - - - - - -';*/
//print_r($schoolTabs); 


$charts = new highCharts;
?>



<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <?php  echo'<link rel="stylesheet" type="text/css" href="'.CSSF_HOME.'" />';
               echo'<link rel="stylesheet" type="text/css" href="'.CSSF_HEADER.'" />';
               echo'<link rel="stylesheet" type="text/css" href="'.CSSF_HELPTEXT.'" />'; 
               echo'<link rel="stylesheet" type="text/css" href="'.CSSF_DEFAULT.'" />';
               echo'<link rel="stylesheet" type="text/css" href="'.CSSF_PROFILE.'" />';
          ?>
        <!--[if IE]><link rel="stylesheet" type="text/css" href="../../_include/css/frontend/IEoverwrite.css"/><![endif]-->
        <title>SCHOOLINZICHT</title>
    </head>
    <body class="body">
        <div id="header">  
            <div id="headercontainer">
                <?php require_once("views/components/frontendHeader.php"); ?>
            </div>
            <div id="helptext">     
                <?php require_once("views/components/infotext.php");   ?>
            </div>
        </div>        
        <div id="content">
            <div id="profileleft">
                <div id="navigatorprofile">
                    <div id="stepback">
      
                        <a href="javascript:history.go(-1)" onmouseover="document.previous.src='http://test.adminfloris.nl/_include/imgFrontend/vorigestaphover.png'" onmouseout="document.previous.src='http://test.adminfloris.nl/_include/imgFrontend/vorigestap.png'">
                            <?php echo '<IMG SRC="'.FRONTEND_IMAGES_PATH.'vorigestap.png" name="previous" alt="Vorige Stap">'?>
                        </a>
           
        </div>
    </div>
 <?php    
            $i = 0; 
          
          //Below section displays the global school information
                echo '<div class="selectedschool">'; 
                echo '<div class="schoolname" ><b>'.$schoolInfo[$i]["schoolName"].'</b></div>';
               //Logo Replacement when its empty in the database
                    if($schoolInfo[$i]["logoPath"] != null) {
                        echo '<div class="schoolpicture"><img src="'.LOGO_IMAGES_PATH.$schoolInfo[$i]["BRIN"].'.png" width="205" /></div>'; 
                        } else { 
                        echo '<div class="schoolpicture"><img src="'.LOGO_IMAGES_PATH.'logo.png" /></div>';
                    }
                echo '<div class="schooladdress"><b>Adres:  </b>  '.$schoolInfo[$i]["address"].'</div>'; 
                echo '<div class="schooltype"><b>Type:  </b>  '.$schoolInfo[$i]["educationType"].'</div>'; 
                echo '<div class="schoolextra"><b>Opvang:  </b>  '.$schoolInfo[$i]["childCare"].'</div>';
                echo '<div class="schoolboard"><b>Bestuur:  </b>  '.$schoolInfo[$i]["boardName"].'</div>'; 
               //website Replacement when its empty in the database 
                    if($schoolInfo[$i]["website"] != null) {
                    echo '<div class="schoolwebsite"><b>Website:  </b><a href="'.$schoolInfo[$i]["website"].'" target="_blank">'.$schoolInfo[$i]["schoolName"].'</a></div>'; 
                        } else { 
                    echo '<div class="schoolwebsite"><b>Website:  </b>Website niet bekend</div>'; 
                    }
                echo '<div class="schoolstudents"><b>Leerlingen:  </b>'.$totalStudents[$i]["totalStudents"].'</div> ';  
                echo '<div class="schoolmission">'; 
                echo'<p><b>Missie</b></p>'; 
                echo nl2br($schoolInfo[$i]["mission"]) ; 
                 
                echo  '</div>';
                echo  '<div class="schoolvision">';
                echo '<p><b>Visie</b></p>';
                 echo nl2br($schoolInfo[$i]["vision"]); 
             
     
     ?>           
            </div>
        </div>
            
</div>
<div id="profileright">
    <div id="profilerighttop">
        <div id="profiletabs">
            <ul>
                <?php
                //Assign default value to make sure the first tab is selected whenever a school is selected
                if($selectedTab == ''){
                    $selectedTab = 1;
                }
                $i=0;
                foreach($schoolTabs as $value) {
                   if($i < $schoolTabsCount) {?>
                       <li <?php if($selectedTab == $schoolTabs[$i]["tabID"] || $selectedTab == '') { echo 'class="currenttabitem"'; } else echo 'class="tabitem"'; ?>><?php echo '<a href="'.FRONTEND_LINK_ROOT.'schoolResults/'.$selectedSchool.'/'.$schoolTabs[$i]["tabID"].'">'.$schoolTabs[$i]["tabName"].'</a></li>'; ?>  
                 
                           
                           
                       <?php $i++;
                   }else{ $i++; } 
                  
                }?>
                
            </ul>
        </div>
    </div>
    <div id="profilerightcontent">     
        <div class="compareschooltext" >
            <b>Algemene Context:</b><br/><br/>
            <?php 

            $i=0;
                    foreach($schoolTabs as $value){
                    if($selectedTab == $schoolTabs[$i]["tabID"]) {
                        echo nl2br($schoolTabs[$i]["tabContext"]);
                        $i++;
                    }else{$i++;} 
                    }

            ?>
        </div>
        <div class="profileschool">
            
             <?php $schoolGraph=1;
             $charts->generateGraph($switchID, $selectedTab, $selectedSchool, $schoolGraph);?>
        </div>    
        <div class="compareschooltext" >
            <p><b>Context door school:</b></p>
                <?php
                    $i=0;
                    foreach($schoolContext as $value){
                    if($selectedTab == $schoolContext[$i]["tabID"]) {
                        echo nl2br($schoolContext[$i]["context"]);
                        $i++;
                    }else{$i++;} 
                    }
                ?>
        </div>
    </div>
</div>
        </div>