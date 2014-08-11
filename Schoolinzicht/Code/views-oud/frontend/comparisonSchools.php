<?php
$pageName = 'comparisonSchools';
//Designed and written in the year 2012, for ASG, by:
//Peter van Kleef, Richard Floris & Pepijn de Vries.
?>

<?php

require_once MODEL_SCHOOL;
require_once MODEL_HIGHCHARTS;
//Test values
//$school1 =  '06RM00';
//$school2 =  '23ZX00';
//$school3 =  '21ND00';

//removes the / and puts the URL in the array
 $idArray = explode('/', $_SERVER['REQUEST_URI']); 
 //removes the & characters and puts them in a new array to divide the selected schools
 $comparison = explode('&', $idArray[2]);

 //Comparison Parameter for the generateGraph() function
 $switchID= 'comparison';
 
 //Define the location in the 2nd array for the selected schools
$school1 = $comparison[0];
$school2 = $comparison[1];
$school3 = $comparison[2];

//Define the location in the array for the tab
$selectedTab = $idArray[3];
 if($selectedTab == ''){
                                $selectedTab = 1;
                            }

//Create a new school object
$school = new school;

$charts = new highCharts;

//Define the function for the showItem Function
$getFunction = 'getSchool';
//Load in the 3 selected schools into arrays
$schoolInfo1 = $school->showItem($getFunction, $school1);
$schoolInfo2 = $school->showItem($getFunction, $school2);
$schoolInfo3 = $school->showItem($getFunction, $school3);

//Load in the tabs
$getFunction = 'getTabs';
$schoolTabs = $school->showItems($getFunction);

//Load in the context for 3 schools
$getFunction = 'getContext';
$schoolContext1 = $school->showItem($getFunction, $school1);
$schoolContext2 = $school->showItem($getFunction, $school2);
$schoolContext3 = $school->showItem($getFunction, $school3);

//Counts the number of tabs retrieved from the database for the while loop at the tabs section.
$schoolTabsCount = count($schoolTabs);

// get the current year and detract 2 to get the desired year from the DB
$today = date("Y");     
$year = $today - 1;


$getFunction = 'getStudentTotal';
$totalStudents1 = $school->showItem($getFunction, $school1, $year);

$totalStudents2 = $school->showItem($getFunction, $school2, $year);

$totalStudents3 = $school->showItem($getFunction, $school3, $year);

$tabID = $selectedTab;
$getFunction = 'getTabText';
$tabInfo = $school->showItems($getFunction, $tabID);

?>
<html>
<head>
    <script>
        function setSideSpacerHeight() {
            var divHeight = document.getElementById('algemeneContext').offsetHeight;
            var newDivHeight = divHeight+5;
            document.getElementById('spacerSide').style.height = newDivHeight;
        }
    </script>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <?php  echo'<link rel="stylesheet" type="text/css" href="'.CSSF_HOME.'" />';
               echo'<link rel="stylesheet" type="text/css" href="'.CSSF_HEADER.'" />';
               echo'<link rel="stylesheet" type="text/css" href="'.CSSF_HELPTEXT.'" />'; 
               echo'<link rel="stylesheet" type="text/css" href="'.CSSF_DEFAULT.'" />';
              // echo'<link rel="stylesheet" type="text/css" href="'.CSSF_PROFILE.'" />';
               echo'<link rel="stylesheet" type="text/css" href="'.CSSF_COMPARISON.'" />';
          ?> 
<!--[if IE]><link rel="stylesheet" type="text/css" href="../../_include/css/frontend/IEoverwrite.css"/><![endif]-->
    <title>SCHOOLINZICHT</title>
   <?php echo' <script language="JavaScript"> ';
      
//this is the mouse over effect for the buttons in the navigator
    echo 'image1 = new Image (); ';
    echo 'image1.src = "'.FRONTEND_IMAGES_PATH.'vorigestapbuttonclicked.png"; '; 
    echo '</script>'; ?>
</head>
<body class="body" onload="javascript:setSideSpacerHeight();">
    <div id="header">  
        <div id="headercontainer">
            <?php require_once("views/components/frontendHeader.php"); ?>
        </div>
        <div id="helptext">     
            <?php require_once("views/components/infotext.php");   ?>
        </div>
    </div>     
    <div id="content">    
        <div id="compareleft">
            <div id="navigator">
                <div id="stepback">
                    <?php //echo'<a href="index.php?p=select" onmouseover="image1.src="../img/vorigestapbuttonclicked.png";"'; 
                          //echo 'onmouseout="image1.src='.FRONTEND_IMAGES_PATH.'"vorigestapbutton.png";">';?>
                    <a href="javascript:history.go(-1)" onmouseover="document.previous.src='http://test.adminfloris.nl/_include/imgFrontend/vorigestaphover.png'" onmouseout="document.previous.src='http://test.adminfloris.nl/_include/imgFrontend/vorigestap.png'">
                        <?php echo '<IMG SRC="'.FRONTEND_IMAGES_PATH.'vorigestap.png" name="previous" alt="Vorige Stap">'?>
                    </a>
                    <?php 
                        echo '<script>';
                        //echo'<a href="javascript:history.go(-1)"><img name="image1" src="'.FRONTEND_IMAGES_PATH.'vorigestapbutton.png" onmouseover="image1.src="'.FRONTEND_IMAGES_PATH.'vorigestapbuttonclicked.png"" alt="" /></a>';
                        echo '</script>';
                    ?>
                </div>
            </div>
            <div id="spacerSide">
                <?php echo nl2br($tabInfo[0]['tabtext']); ?>
            </div>
            <div class="selectedschool">
                <?php
                $i=0;
                //Original method of linking - doesn't work in echo's
                //echo '<div class="schoolname1" onclick="location.href='.FRONTEND_LINK_ROOT.'schoolResults/'.$school1.'" style="cursor: pointer" >'.$schoolInfo1[$i]["schoolName"].'</div>';
                //Display data for the first school,
                    echo '<div class="schoolname1"> <a href="'.FRONTEND_LINK_ROOT.'schoolResults/'.$school1.'" style="text-decoration: none; color: #000000;" ><b>'.$schoolInfo1[$i]["schoolName"].'</b></div></a>';
                    echo '<div class="schooladdress"><b>Adres:  </b>  '.$schoolInfo1[$i]["address"].'</div>'; 
                    echo '<div class="schooltype"><b>Type:  </b>  '.$schoolInfo1[$i]["educationType"].'</div>'; 
                    echo '<div class="schoolextra"><b>Opvang:  </b>  '.$schoolInfo1[$i]["childCare"].'</div>';
                    echo '<div class="schoolboard"><b>Bestuur:  </b>  '.$schoolInfo1[$i]["boardName"].'</div>'; 
                    echo '<div class="schoolstudents"><b>Leerlingen:  </b>'.$totalStudents1[$i]["totalStudents"].'</div> ';  
                ?>
            </div>
            <div class="selectedschool">
                <?php
                    //Display data for the second school
                    echo '<div class="schoolname2"> <a href="'.FRONTEND_LINK_ROOT.'schoolResults/'.$school2.'" style="text-decoration: none; color: #000000;" ><b>'.$schoolInfo2[$i]["schoolName"].'</b></div></a>';
                    echo '<div class="schooladdress"><b>Adres:  </b>  '.$schoolInfo2[$i]["address"].'</div>'; 
                    echo '<div class="schooltype"><b>Type:  </b>  '.$schoolInfo2[$i]["educationType"].'</div>'; 
                    echo '<div class="schoolextra"><b>Opvang:  </b>  '.$schoolInfo2[$i]["childCare"].'</div>';
                    echo '<div class="schoolboard"><b>Bestuur:  </b>  '.$schoolInfo2[$i]["boardName"].'</div>'; 
                    echo '<div class="schoolstudents"><b>Leerlingen:  </b>'.$totalStudents2[$i]["totalStudents"].'</div> ';  
                ?>
            </div>
          <?php if($school3 != '') {?>
            <div class="selectedschool2">
                <?php
                    //Display data for the 3rth school
                    echo '<div class="schoolname3"> <a href="'.FRONTEND_LINK_ROOT.'schoolResults/'.$school3.'" style="text-decoration: none; color: #000000;" ><b>'.$schoolInfo3[$i]["schoolName"].'</b></div></a>';
                    echo '<div class="schooladdress"><b>Adres:  </b>  '.$schoolInfo3[$i]["address"].'</div>'; 
                    echo '<div class="schooltype"><b>Type:  </b>  '.$schoolInfo3[$i]["educationType"].'</div>'; 
                    echo '<div class="schoolextra"><b>Opvang:  </b>  '.$schoolInfo3[$i]["childCare"].'</div>';
                    echo '<div class="schoolboard"><b>Bestuur:  </b>  '.$schoolInfo3[$i]["boardName"].'</div>'; 
                    echo '<div class="schoolstudents"><b>Leerlingen:  </b>'.$totalStudents3[$i]["totalStudents"].'</div> ';  
                ?>
            </div>
          <?}else{ }?>
        </div>
        <div id="compareright">
            <div id="comparerighttop">
                <div id="comparetabs">
                    <ul>
                        <?php
                            //Assign default value to make sure the first tab is selected whenever a school is selected
                            if($selectedTab == ''){
                                $selectedTab = 1;
                            }
                            $i=0;
                            foreach($schoolTabs as $value) {
                                if($i < $schoolTabsCount) {?>
                                    <li <?php if($selectedTab == $schoolTabs[$i]["tabID"] || $selectedTab == '') { echo 'class="currenttabitem"'; } else echo 'class="tabitem"'; ?>><?php echo '<a href="'.FRONTEND_LINK_ROOT.'comparisonSchools/'.$school1.'&'.$school2.'&'.$school3.'/'.$schoolTabs[$i]["tabID"].'">'.$schoolTabs[$i]["tabName"].'</a></li>'; ?>  
                                    <?php $i++;
                                }
                                else { $i++; } 
                            } 
                        ?>
                    </ul>
                </div>
            </div>
            <div id="comparerightcontent">
                <div id="algemeneContext">
                    <b>Algemene Context:</b><br/><br/>
                    <?php $i=0;
                        foreach($schoolTabs as $value){
                            if($selectedTab == $schoolTabs[$i]["tabID"]) {
                            echo nl2br($schoolTabs[$i]["tabContext"]);
                            $i++;
                            }else{$i++;} 
                        }
                    ?>
                </div>
                <div class="compareschool">
                    <?php  
                        $schoolGraph = 1;
                        $charts->generateGraph($switchID, $selectedTab, $school1, $schoolGraph);?>
                    <div class="compareschooltextmall">
                        <p><b>Context door school:</b></p>
                        <?php    $i=0;
                            foreach($schoolContext1 as $value){
                                if($selectedTab == $schoolContext1[$i]["tabID"]) {
                                echo nl2br($schoolContext1[$i]["context"]);
                                $i++;
                                }else{$i++;} 
                            }
                        ?>
                    </div>
                </div>
                <div class="compareschool">
                    <?php  
                        $schoolGraph = 2;
                        $charts->generateGraph($switchID, $selectedTab, $school2, $schoolGraph);?>
                    <div class="compareschooltextmall">
                        <p><b>Context door school:</b></p>
                        <?php    $i=0;
                            foreach($schoolContext2 as $value){
                                if($selectedTab == $schoolContext2[$i]["tabID"]) {
                                echo nl2br($schoolContext2[$i]["context"]);
                                $i++;
                                }else{$i++;} 
                            }
                        ?>
                    </div>
                </div>
              <?php if($school3 != '') {?>
                <div class="compareschool">
                    <?php  
                        $schoolGraph = 3;
                        $charts->generateGraph($switchID, $selectedTab, $school3, $schoolGraph);?>
                    <div class="compareschooltextmall">
                        <p><b>Context door school:</b></p>
                        <?php    $i=0;
                            foreach($schoolContext3 as $value){
                                if($selectedTab == $schoolContext3[$i]["tabID"]) {
                                echo nl2br($schoolContext3[$i]["context"]);
                                $i++;
                                }else{$i++;} 
                            }
                        ?>
                    </div>
                </div>
            <?}else{ }?>
            </div>
        </div>
    </div>
</body>