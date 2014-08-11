<?php

//Designed and written in the year 2012, for ASG, by:
//Peter van Kleef, Richard Floris & Pepijn de Vries.

require_once MODEL_CRITERIA;
    $pageName = 'selSchoolList';

//Checks if theres any content posted in the page after selecting the desired schools in this page. , assigns them to variables and unsets the post afterwards.
//After which the header puts the variables in the URL and redirects them to the selection 

$i=0;

if(isset($_POST)){

    //removes the criteria aanpassen button value from the array
      unset($_POST["refresh"]);
      
      //Checks if the post values were from a selection or from a criteria update
    if(empty($_POST["postcode"]) && empty($_POST["afstand"]) && empty($_POST["students"])){
       foreach($_POST as $value){
         $selectedSchool[$i] = $value;
         $i++;
        }
        //Checks the values and assigns the values if they are schools.
        if(isset($selectedSchool[0])){
        $firstSchool = ''.$selectedSchool[0].'';    
        }
         if(isset($selectedSchool[1])){
          $secondSchool = '&'.$selectedSchool[1].'';    
         }
          if(isset($selectedSchool[2])){
          $thirthSchool = '&'.$selectedSchool[2].'';    
          }
    }else{
       //puts all the criteriavalues into one string.
        foreach($_POST as $value){
           $criteriaValues =  $criteriaValues.$value;
        }
       
    }
//Delete Post when handled.     
 unset($_POST);
     if(isset($firstSchool)){ 
    header('Location: '.FRONTEND_LINK_ROOT.'selection/'.$firstSchool.$secondSchool.$thirthSchool.'');
}
if(!empty($criteriaValues)){
   header('Location: '.FRONTEND_LINK_ROOT.'selSchoolList/'.$criteriaValues.'');    
    }
}
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

//define what the current sorting style is:
$sortingFull = $urlParts[2];
$sortingSplit = explode("-", $sortingFull);
$selectedSorting = $sortingSplit[0];

//define how the sorting URLS will be, based on the current situation:
if(($sortingSplit[1] == '' || $sortingSplit[1] == '1') && $sortingSplit[0] == '1') {
    $sortingURL1 = '2';
    $sortingURL2 = '1';
    $sortingURL3 = '1';
    $sortingURL4 = '1';
}
elseif(($sortingSplit[1] == '' || $sortingSplit[1] == '1') && $sortingSplit[0] == '2') {
    $sortingURL1 = '1';
    $sortingURL2 = '2';
    $sortingURL3 = '1';
    $sortingURL4 = '1';
}
elseif(($sortingSplit[1] == '' || $sortingSplit[1] == '1') && $sortingSplit[0] == '3') {
    $sortingURL1 = '1';
    $sortingURL2 = '1';
    $sortingURL3 = '2';
    $sortingURL4 = '1';
}
elseif(($sortingSplit[1] == '' || $sortingSplit[1] == '1') && $sortingSplit[0] == '4') {
    $sortingURL1 = '1';
    $sortingURL2 = '1';
    $sortingURL3 = '1';
    $sortingURL4 = '2';
}
else {
    $sortingURL1 = '1';
    $sortingURL2 = '1';
    $sortingURL3 = '1';
    $sortingURL4 = '1';
}

//removes the / from the URL given from the SchoolList and puts the values in an array, to identify which school and tab is selected.
  $idArray = explode('/', $_SERVER['REQUEST_URI']); 

//Assigns the selected sorting to the variable.
//   $selectedSorting = $sorting;
?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <?php echo'<link rel="stylesheet" type="text/css" href="'.CSSF_HOME.'" />';
               echo'<link rel="stylesheet" type="text/css" href="'.CSSF_HEADER.'" />';
               echo'<link rel="stylesheet" type="text/css" href="'.CSSF_HELPTEXT.'" />'; 
               echo'<link rel="stylesheet" type="text/css" href="'.CSSF_DEFAULT.'" />';
               echo'<link rel="stylesheet" type="text/css" href="'.CSSF_LISTVIEW.'" />';
        ?>
  <!--[if IE]><link rel="stylesheet" type="text/css" href="../../_include/css/frontend/IEoverwrite.css"/><![endif]-->
        <script language="JavaScript" type="text/javascript">
//    the following functions count the number of selected 
//    list items, min. 2, max 3 to go to the next page
//    sets the count to 0 by default:
    globalVar = 0;

//    sets the count to +1 when an item is checked:
    function upNumChecks() {
       globalVar = globalVar +1;
    }
//    sets the count to -1 when an item is unchecked:
     function downNumChecks() {
       globalVar = globalVar -1;
    }
//  shows the 'vergelijken' knop when 2 or 3 items are <INPUT TYPE="image" SRC="../../_include/imgFrontend/vergelijkenbuttonblue.png" ALT="Submit Form">
//selected, if not it shows the grey button:    <input type="submit" value="Test">
    function displayVergelijkKnop() {
        if(globalVar > '1' && globalVar < '4') {
            document.getElementById("p1").innerHTML='<input type="submit"  class="submitcompare" value="submitcompare" pointer="cursor"/>'; 
        }
        else {
            document.getElementById("p1").innerHTML='<a><img src="../../_include/imgFrontend/vergelijkengrey.png" alt="" class="image" /></a>';
        }
    }
  // Function for showing the list.
  
//Function for color replacement during selection.
   /* function changeColor(){
    if(globalVar = '1'){
        document.getElementById("listitem").style.backgroundcolor="#CCCC00";
    }else if (globalVar = '2'){
        
    }else if (globalVar = '3'){ 
        
    }else if (globalVar = '4'){
        
    }
    } */
//this is the mouse over effect for the buttons in the navigator
    image1 = new Image (); 
    image1.src = "../../_include/imgFrontend/vorigestapbuttonclicked.png"; 
    image2 = new Image (); 
    image2.src = "../../_include/imgFrontend/tegelweergavebuttonclicked.png"; 
    image3 = new Image (); 
    image3.src = "../../_include/imgFrontend/kaartweergavebuttonclicked.png"; 
</script>
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
            <div id="listleft">
                <?php require_once('views/components/sideBar.php');  ?>
            </div> 
            <div id="listright">
                <form method="POST" action="" name="list" id="list">
                <div id="listrighttop">              
                    <div id="listtabs">
                        <ul>
                            <?php 
                            // checks what tab is active at the moment, 'naam' and nothing ('') being default.
                            // displays different menustyle for active tab. 

                                if($selectedSorting == '1' || $selectedSorting == ''){
                                    echo '<li class="currenttabitem"><a href="'.FRONTEND_LINK_ROOT.'selSchoolList/'.$urlParts[0].'='.$urlParts[1].'=1-'.$sortingURL1.'">Naam</a></li>';
                                }
                                else {
                                    echo '<li class="tabitem"><a href="'.FRONTEND_LINK_ROOT.'selSchoolList/'.$urlParts[0].'='.$urlParts[1].'=1-'.$sortingURL1.'">Naam</a></li>';
                                }
                                if($selectedSorting == '2'){
                                    echo '<li class="currenttabitem"><a href="'.FRONTEND_LINK_ROOT.'selSchoolList/'.$urlParts[0].'='.$urlParts[1].'=2-'.$sortingURL2.'">Afstand</a></li>';
                                }
                                else {
                                    echo '<li class="tabitem"><a href="'.FRONTEND_LINK_ROOT.'selSchoolList/'.$urlParts[0].'='.$urlParts[1].'=2-'.$sortingURL2.'">Afstand</a></li>';
                                }
                                if($selectedSorting == '3'){
                                        echo '<li class="currenttabitem"><a href="'.FRONTEND_LINK_ROOT.'selSchoolList/'.$urlParts[0].'='.$urlParts[1].'=3-'.$sortingURL3.'">Soort Onderwijs</a></li>';
                                }
                                else {
                                echo '<li class="tabitem"><a href="'.FRONTEND_LINK_ROOT.'selSchoolList/'.$urlParts[0].'='.$urlParts[1].'=3-'.$sortingURL3.'">Soort Onderwijs</a></li>';
                                }
                                if($selectedSorting == '4'){
                                    echo '<li class="currenttabitem"><a href="'.FRONTEND_LINK_ROOT.'selSchoolList/'.$urlParts[0].'='.$urlParts[1].'=4-'.$sortingURL4.'">Aantal Leerlingen</a></li>';
                                }
                                else {
                                    echo '<li class="tabitem"><a href="'.FRONTEND_LINK_ROOT.'selSchoolList/'.$urlParts[0].'='.$urlParts[1].'=4-'.$sortingURL4.'">Aantal Leerlingen</a></li>';
                                }
                            ?>
                        </ul>
                    </div> 
                    <div id="listvergelijken">
                          
                        <?php echo'<p id = "p1"><a><img src="'.FRONTEND_IMAGES_PATH.'vergelijkengrey.png" alt="" class="image" id="list" /></a></p>' ;?>
                    </div>  
                </div>
                <div id="listrightcontent">
                        <?php 
                          //define how the sorting will take place, on which criterium
                          //and DESC or ASC:
                            if($selectedSorting == '3') {
                                $n=0;
                                foreach($schoolcontent as $row) {
                                    $soortonderwijs[$n] = $row['educationType'];
                                    $n++;
                                }
                                if($sortingSplit[1] == '1' || $sortingSplit[1] == '') {
                                    array_multisort($soortonderwijs, SORT_ASC, $schoolcontent);
                                }
                                else {
                                    array_multisort($soortonderwijs, SORT_DESC, $schoolcontent);
                                }
                            }
                            elseif($selectedSorting == '2') {
                                $n=0;
                                foreach($schoolcontent as $key => $row) {
                                    $distanceEE[$n] = $row['distance'];
                                    $n++;
                                }
                                if($sortingSplit[1] == '1' || $sortingSplit[1] == '') {
                                    array_multisort($distanceEE, SORT_ASC, $schoolcontent);
                                }
                                else {
                                    array_multisort($distanceEE, SORT_DESC, $schoolcontent);
                                }   
                            }
                            elseif($selectedSorting == '4') {
                                $n=0;
                                foreach($schoolcontent as $key => $row) {
                                    $noStudenten[$n] = $row['studentNO'];
                                    $n++;
                                }
                                if($sortingSplit[1] == '1' || $sortingSplit[1] == '') {
                                    array_multisort($noStudenten, SORT_ASC, $schoolcontent);
                                }
                                else {
                                    array_multisort($noStudenten, SORT_DESC, $schoolcontent);
                                }  
                            }
                            else {
                                $n=0;
                                foreach($schoolcontent as $row) {
                                    $naam[$n] = $row['schoolName'];
                                    $n++;
                                }
                                if($sortingSplit[1] == '1' || $sortingSplit[1] == '') {
                                    array_multisort($naam, SORT_ASC, $schoolcontent);
                                }
                                else {
                                    array_multisort($naam, SORT_DESC, $schoolcontent);
                                }
                            }
                            //place the remaining schools:
                                foreach ($schoolcontent as $value) {
                                    
                                    echo         '<div class="listitem">'; 
                                    echo         '<div class="listname"><a href="'.FRONTEND_LINK_ROOT.'schoolResults/'.$value["BRIN"].'" style="text-decoration: none; color: #000000;"><center>'.$value["schoolName"].'</center></a></div>';
                                    if(!empty($value['distance'])) {
                                        echo         '<div class="listdistance">'.$value['distance'].'  KM</div>' ;
                                    }
                                    else {
                                        echo         '<div class="listdistance">N.B.</div>' ;
                                    }
                                    echo         '<div class="listtype">'.$value["educationType"].'</div>';
                                    if(!empty($value['studentNO'])) {
                                        echo         '<div class="liststudents">'.$value["studentNO"].'</div>';
                                    }
                                    else {
                                        echo         '<div class="liststudents">N.B.</div>';
                                    }
                                    echo         '<div class="listselect"><input type="checkbox" name="checkbox'.$value["BRIN"].'" value="'.$value["BRIN"].'" class="listcheckbox" onclick="if (this.checked) {upNumChecks(), displayVergelijkKnop()} else {downNumChecks(), displayVergelijkKnop()}" /></div>';

                                }
                        ?>  
                </div>
             </form>           
        </div>
        </div>
    </body>
</html>