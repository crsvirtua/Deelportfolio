<?php

//Designed and written in the year 2012, for ASG, by:
//Peter van Kleef, Richard Floris & Pepijn de Vries.

class backController extends baseController {

}

//this determines the url that is requested:
//(all / are new array values so:
// /home/3 = array('home', '3')):
$array = explode('/',$_SERVER['REQUEST_URI']); 
array_shift($array); 
//select which part of the array we use for
//selecting a view (in this case always
//the second value (/administration/$view):
$view = $array[1];

//determine which views exist (for the backend:
$viewsBackend = array(
    'articleDetail',
    'articleList',
    'contextDetail',
    'itemDetail',
    'itemList',
    'login',
    'schoolDetail',
    'schoolList',
    'updatesList',
    'uploadCSV',
    'userDetail',
    'userList',
    'logout',
    'resetPassword',
    'contentManagement',
    'contentManagementDetail',
    'schoolUpdate',
    'schoolDetail1',
    'createNew'
);

//determine that if no view was entered we select
//articleList view:
if(empty($view)) {
    $view = 'login';
}
//if the selected view is an 'existing' view,
//load if:
if(in_array($view,$viewsBackend)) {
    require_once "views/backend/{$view}.php";
}
//if the selected view does not exist show a
//custom errorpage:
elseif(!in_array($view,$viewsBackend)) {
    require_once "views/errors/backend404.php";
}

?>