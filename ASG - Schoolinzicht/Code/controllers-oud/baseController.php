<?php

//Designed and written in the year 2012, for ASG, by:
//Peter van Kleef, Richard Floris & Pepijn de Vries.

class baseController {
   
    
}

//this determines the url that is requested:
//(all / are new array values so:
// /home/3 = array('home', '3')):
$section = explode('/',$_SERVER['REQUEST_URI']); 
array_shift($section);

//select which part of the array we use for
//selecting a section (in this case always
//the first value (/administration/something):
$selectedsection = $section[0];

//set the ONLY available backend 'URL start',
//any other will result in a frontend request:
$selectbackend = array('administration');

//if the section is 'administration',
//send the user to the backcontroller:
if(in_array($selectedsection, $selectbackend)) {
    require_once("backend/backController.php");    
}

//else: send the user to the frontend (controller):
else {
    require_once("frontend/homeController.php");
} 

?>