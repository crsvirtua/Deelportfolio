<?php
$pageName = 'selection';
//Designed and written in the year 2012, for ASG, by:
//Peter van Kleef, Richard Floris & Pepijn de Vries.

?><?php

require_once MODEL_SCHOOL;


 $idArray = explode('/', $_SERVER['REQUEST_URI']); 
 $comparison = explode('&', $idArray[2]);
//Test values
$school1 =  $comparison[0];
$school2 =  $comparison[1];
$school3 =  $comparison[2];

//Link for the comparison button
$link = 'comparisonSchools/'.$school1.'&'.$school2.'&'.$school3.'';

//Create a new school object
$school = new school;

//Define the function for the showItem Function
$getFunction = 'getSchool';

//Load in the 3 selected schools into arrays
$schoolInfo1 = $school->showItem($getFunction, $school1);
$schoolInfo2 = $school->showItem($getFunction, $school2);
$schoolInfo3 = $school->showItem($getFunction, $school3);

$getFunction = 'getStudentTotal';
// get the current year and detract 2 to get the desired year from the DB
$today = date("Y");     
$year = $today - 1;
$totalStudents1 = $school->showItem($getFunction, $school1, $year);

$totalStudents2 = $school->showItem($getFunction, $school2, $year);

$totalStudents3 = $school->showItem($getFunction, $school3, $year);

?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <?php  echo'<link rel="stylesheet" type="text/css" href="'.CSSF_HOME.'" />';
               echo'<link rel="stylesheet" type="text/css" href="'.CSSF_HEADER.'" />';
               echo'<link rel="stylesheet" type="text/css" href="'.CSSF_HELPTEXT.'" />'; 
               echo'<link rel="stylesheet" type="text/css" href="'.CSSF_DEFAULT.'" />';
               //echo'<link rel="stylesheet" type="text/css" href="'.CSSF_PROFILE.'" />';
               //echo'<link rel="stylesheet" type="text/css" href="'.CSSF_LISTVIEW.'" />';
                 echo'<link rel="stylesheet" type="text/css" href="'.CSSF_SELECTION.'" />';
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
        <div id="selectleft">
            <?php require_once('views/components/sideBar.php');  ?>
        </div>
        <div id="selectright">
            <div id="selectrighttop">
                <div id="selectvergelijken">
                    <?php echo'<p id = "p1"><a href="'.FRONTEND_LINK_ROOT.'comparisonSchools/'.$school1.'&'.$school2.'&'.$school3.'"><img src="'.FRONTEND_IMAGES_PATH.'vergelijken.png" alt="" class="image" /></a></p>' ;?>
                </div>
            </div>
            <div id="selectrightcontent">
                <div class="selectedschool1">
                    <?php
                    $i=0;
                    //Display data for the first school
                        echo '<div id="schoolname1"> <a href="'.FRONTEND_LINK_ROOT.'schoolResults/'.$school1.'" style="text-decoration: none; color: #000000;"  ><b>'.$schoolInfo1[$i]["schoolName"].'</b></a></div>';
                        //Logo Replacement when its empty in the database
                                if($schoolInfo1[$i]["logoPath"] != null) {
                                    echo '<div class="schoolpicture"><img src="'.LOGO_IMAGES_PATH.$schoolInfo1[$i]["BRIN"].'.png" width="205" /></div>'; 
                                    } else { 
                                    echo '<div class="schoolpicture"><img src="'.LOGO_IMAGES_PATH.'logo.png" /></div>';
                                }
                            echo '<div class="schooladdress"><b>Adres:  </b>  '.$schoolInfo1[$i]["address"].'</div>'; 
                            echo '<div class="schooltype"><b>Type:  </b>  '.$schoolInfo1[$i]["educationType"].'</div>'; 
                            echo '<div class="schoolextra"><b>Opvang:  </b>  '.$schoolInfo1[$i]["childCare"].'</div>';
                            echo '<div class="schoolboard"><b>Bestuur:  </b>  '.$schoolInfo1[$i]["boardName"].'</div>'; 
                        //website Replacement when its empty in the database 
                                if($schoolInfo1[$i]["website"] != null) {
                                echo '<div class="schoolwebsite"><b>Website:  </b><a href="'.$schoolInfo1[$i]["website"].'">'.$schoolInfo1[$i]["schoolName"].'</a></div>'; 
                                    } else { 
                                echo '<div class="schoolwebsite"><b>Website:  </b>Website niet bekend</div>'; 
                                }
                            echo '<div class="schoolstudents"><b>Leerlingen:  </b>'.$totalStudents1[$i]["totalStudents"].'</div> ';  
                            echo '<div class="schoolmission">'; 
                            echo'<p><b>MISSIE</b></p>'; 
                            echo $schoolInfo1[$i]["mission"] ; 

                            echo  '</div>';
                            echo  '<div class="schoolvision">';
                            echo '<p><b>VISIE</b></p>';
                            echo $schoolInfo1[$i]["vision"] ; 
                            echo '</div>'; 
                    ?>
                </div>
                <div class="selectedschool">
                    <?php
                    //Display data for the second school
                    echo '<div id="schoolname2"> <a href="'.FRONTEND_LINK_ROOT.'schoolResults/'.$school2.'" style="text-decoration: none; color: #000000;"  ><b>'.$schoolInfo2[$i]["schoolName"].'</b></a></div>';
                        //Logo Replacement when its empty in the database
                                if($schoolInfo2[$i]["logoPath"] != null) {
                                    echo '<div class="schoolpicture"><img src="'.LOGO_IMAGES_PATH.$schoolInfo2[$i]["BRIN"].'.png" width="205" /></div>'; 
                                    } else { 
                                    echo '<div class="schoolpicture"><img src="'.LOGO_IMAGES_PATH.'logo.png" /></div>';
                                }
                            echo '<div class="schooladdress"><b>Adres:  </b>  '.$schoolInfo2[$i]["address"].'</div>'; 
                            echo '<div class="schooltype"><b>Type:  </b>  '.$schoolInfo2[$i]["educationType"].'</div>'; 
                            echo '<div class="schoolextra"><b>Opvang:  </b>  '.$schoolInfo2[$i]["childCare"].'</div>';
                            echo '<div class="schoolboard"><b>Bestuur:  </b>  '.$schoolInfo2[$i]["boardName"].'</div>'; 
                        //website Replacement when its empty in the database 
                                if($schoolInfo2[$i]["website"] != null) {
                                echo '<div class="schoolwebsite"><b>Website:  </b><a href="'.$schoolInfo2[$i]["website"].'">'.$schoolInfo2[$i]["schoolName"].'</a></div>'; 
                                    } else { 
                                echo '<div class="schoolwebsite"><b>Website:  </b>Website niet bekend</div>'; 
                                }
                            echo '<div class="schoolstudents"><b>Leerlingen:  </b>'.$totalStudents2[$i]["totalStudents"].'</div> ';  
                            echo '<div class="schoolmission">'; 
                            echo'<p><b>MISSIE</b></p>'; 
                            echo $schoolInfo2[$i]["mission"] ; 

                            echo  '</div>';
                            echo  '<div class="schoolvision">';
                            echo '<p><b>VISIE</b></p>';
                            echo $schoolInfo2[$i]["vision"] ; 
                            echo '</div>'; 
                    ?>
                </div>
          <?php if($school3 != ''){?>
                <div class="selectedschool">
                    <?php  
                    //Display data for the 3rth school
                        echo '<div id="schoolname3"> <a href="'.FRONTEND_LINK_ROOT.'schoolResults/'.$school3.'" style="text-decoration: none; color: #000000;"  ><b>'.$schoolInfo3[$i]["schoolName"].'</b></a></div>';
                        //Logo Replacement when its empty in the database
                                if($schoolInfo3[$i]["logoPath"] != null) {
                                    echo '<div class="schoolpicture"><img src="'.LOGO_IMAGES_PATH.$schoolInfo3[$i]["BRIN"].'.png" width="205"/></div>'; 
                                    } else { 
                                    echo '<div class="schoolpicture"><img src="'.LOGO_IMAGES_PATH.'logo.png" /></div>';
                                }
                            echo '<div class="schooladdress"><b>Adres:  </b>  '.$schoolInfo3[$i]["address"].'</div>'; 
                            echo '<div class="schooltype"><b>Type:  </b>  '.$schoolInfo3[$i]["educationType"].'</div>'; 
                            echo '<div class="schoolextra"><b>Opvang:  </b>  '.$schoolInfo3[$i]["childCare"].'</div>';
                            echo '<div class="schoolboard"><b>Bestuur:  </b>  '.$schoolInfo3[$i]["boardName"].'</div>'; 
                        //website Replacement when its empty in the database 
                                if($schoolInfo3[$i]["website"] != null) {
                                echo '<div class="schoolwebsite"><b>Website:  </b><a href="'.$schoolInfo3[$i]["website"].'">'.$schoolInfo3[$i]["schoolName"].'</a></div>'; 
                                    } else { 
                                echo '<div class="schoolwebsite"><b>Website:  </b>Website niet bekend</div>'; 
                                }
                            echo '<div class="schoolstudents"><b>Leerlingen:  </b>'.$totalStudents3[$i]["totalStudents"].'</div> ';  
                            echo '<div class="schoolmission">'; 
                            echo'<p><b>MISSIE</b></p>'; 
                            echo $schoolInfo3[$i]["mission"] ; 

                            echo  '</div>';
                            echo  '<div class="schoolvision">';
                            echo '<p><b>VISIE</b></p>';
                            echo $schoolInfo3[$i]["vision"] ; 
                            echo '</div>'; 
                    ?>
                </div>
            <?php } else { ?>  
                <div class="selectedschool">
                    <?php //<a href="'.FRONTEND_LINK_ROOT.'selSchoolList"> <img src="'.FRONTEND_IMAGES_PATH.'emptyschool.png"></a>echo '';} ?> 
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</body>