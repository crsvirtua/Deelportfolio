<?php    

//Designed and written in the year 2012, for ASG, by:
//Peter van Kleef, Richard Floris & Pepijn de Vries.

class homeController extends baseController {

}
//this determines the url that is requested:
//(all / are new array values so:
// /home/3 = array('home', '3')):
$array = explode('/',$_SERVER['REQUEST_URI']); 
array_shift($array); 
//select which part of the array we use for
//selecting a view (in this case always
//the second value (/administration/$view):
$view = $array[0];

//determine which views exist:
$viewsFrontend = array(
'comparisonSchools',
'home',
'schoolResults',
'selSchoolList',
'selSchoolMap',
'selection',
'faq',
'contact',
'schoolUpdate', 
'UploadScherm',
'Upload',
'intro'

);

//determine that if no view was entered we select
//articleList view:
if(empty($view)) {
    $view = 'intro';
}
//if the selected view is an 'existing' view,
//load if:
if(in_array($view,$viewsFrontend)) {
    require_once "views/frontend/{$view}.php";
}
//if the selected view does not exist show a
//custom errorpage:
elseif(!in_array($view,$viewsFrontend)) {
    require_once "views/errors/404.php";
}

?>