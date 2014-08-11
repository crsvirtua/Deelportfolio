<?php

//Designed and written in the year 2012, for ASG, by:
//Peter van Kleef, Richard Floris & Pepijn de Vries.

//the basic constants:
define('DBHost', 'localhost');
define('DBUser', 'schoolinzicht');
define('DBPassword', 'A728hwitdh67');
define('DBName', 'schoolinzicht');

//sets error messages on or off:
// dev shows errors
// live shows none
define('APPStatus', 'dev');
switch (APPStatus) {
    case 'dev': {
        ini_set('html_errors', 1);
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        ini_set('error_reporting', 1);
    }
    case 'live': {
        ini_set('html_errors', 0);
        ini_set('display_errors', 0);
        ini_set('display_startup_errors', 0);
        ini_set('error_reporting', 0);
    }
}


//FOLLOWING DEFINES ALL FILE PATHS:
//basic paths:
define("MODELS_PATH", "models/");
define("CONTROLLERS_PATH", "controllers/");
define("VIEWS_PATH", "views/");
define("INCLUDES_PATH", "_include/");
define("BACKEND_LINK_ROOT", "http://schoolinzichtalmere.nl/administration/");
define("FRONTEND_LINK_ROOT", "http://schoolinzichtalmere.nl/");


//file path:
//include files:
define("INCLUDE_BOOTSTRAP", INCLUDES_PATH."bootstrap.php");
define("INCLUDE_DBMANAGER", INCLUDES_PATH."dbManager.php");
define("INCLUDE_QUERYMANAGER", INCLUDES_PATH."queryManager.php");
define("INCLUDE_SYNTAXCHECKER", INCLUDES_PATH."syntaxChecker.php");
define("INCLUDE_CSVQUERYMANAGER", INCLUDES_PATH."CSVqueryManager.php");


//file paths:
//MODELS:
define("MODEL_ARTICLE", MODELS_PATH."article.php");
define("MODEL_BASEMODEL", MODELS_PATH."baseModel.php");
define("MODEL_CRITERIA", MODELS_PATH."criteria.php");
define("MODEL_CSV", MODELS_PATH."csv.php");
define("MODEL_HIGHCHARTS", MODELS_PATH."highCharts.php");
define("MODEL_INFOTEXT", MODELS_PATH."infotext.php");
define("MODEL_LOCATION", MODELS_PATH."location.php");
define("MODEL_MENU", MODELS_PATH."menu.php");
define("MODEL_SCHOOL", MODELS_PATH."school.php");
define("MODEL_SEARCH", MODELS_PATH."search.php");
define("MODEL_SORTING", MODELS_PATH."sorting.php");
define("MODEL_TAB", MODELS_PATH."tab.php");
define("MODEL_USER", MODELS_PATH."user.php");
define("MODEL_CHARTCOMPONENT", MODELS_PATH."chartComponent.php");
//file paths:
//base CONTROLLERS:
define("CONTROLLER_BASE", CONTROLLERS_PATH."baseController.php");
define("CONTROLLER_MENU", CONTROLLERS_PATH."menuController.php");
define("CONTROLLER_SCHOOL", CONTROLLERS_PATH."schoolController.php");
//backend CONTROLLERS:
define("CONTROLLER_ARTICLE", CONTROLLERS_PATH."backend/articleController.php");
define("CONTROLLER_BACK", CONTROLLERS_PATH."backend/backController.php");
define("CONTROLLER_CRITERIA", CONTROLLERS_PATH."backend/criteriaController.php");
define("CONTROLLER_CSV", CONTROLLERS_PATH."backend/csvController.php");
define("CONTROLLER_USER", CONTROLLERS_PATH."backend/userController.php");
//frontend CONTROLLERS:
define("CONTROLLER_COMPARISON", CONTROLLERS_PATH."frontend/comparisonController.php");
define("CONTROLLER_HOME", CONTROLLERS_PATH."frontend/homeController.php");
define("CONTROLLER_SEARCH", CONTROLLERS_PATH."frontend/searchController.php");

//file paths:
//base VIEW:
define("VIEW_BASECLASS", VIEWS_PATH."viewBaseClass.php");
//backend VIEWS:
define("VIEW_ARTICLEDETAIL", VIEWS_PATH."backend/articleDetail.php");
define("VIEW_ARTICLELIST", VIEWS_PATH."backend/articleList.php");
define("VIEW_CONTEXTDETAIL", VIEWS_PATH."backend/contextDetail.php");
define("VIEW_ITEMDETAIL", VIEWS_PATH."backend/itemDetail.php");
define("VIEW_ITEMLIST", VIEWS_PATH."backend/itemList.php");
define("VIEW_SCHOOLDETAIL", VIEWS_PATH."backend/schoolDetail.php");
define("VIEW_SCHOOLLIST", VIEWS_PATH."backend/schoolList.php");
define("VIEW_UPDATESLIST", VIEWS_PATH."backend/updatesList.php");
define("VIEW_UPLOADCSV", VIEWS_PATH."backend/uploadCSV.php");
define("VIEW_USERDETAIL", VIEWS_PATH."backend/userDetail.php");
define("VIEW_USERLIST", VIEWS_PATH."backend/userList.php");
//frontend VIEWS:
define("VIEW_COMPARISONSCHOOLS", VIEWS_PATH."frontend/comparisonSchools.php");
define("VIEW_HOME", VIEWS_PATH."frontend/home.php");
define("VIEW_SCHOOLRESULTS", VIEWS_PATH."frontend/schoolResults.php");
define("VIEW_SEARCHRESULTS", VIEWS_PATH."frontend/searchResults.php");
define("VIEW_SELSCHOOLLIST", VIEWS_PATH."frontend/selSchoolList.php");
define("VIEW_SELSCHOOLMAP", VIEWS_PATH."frontend/selSchoolMap.php");
define("VIEW_SELECTION", VIEWS_PATH."frontend/selection.php");
define("VIEW_SELECTIONBASECLASS", VIEWS_PATH."frontend/selectionBaseClass.php");
define("VIEW_FAQ", VIEWS_PATH."frontend/faq.php");
define("VIEW_CONTACT", VIEWS_PATH."frontend/contact.php");
//file paths:
//backend CSS FILES:
define("CSSB_DEFAULT", "../../_include/css/backend/default.css");
define("CSSB_EDITCONTENT", "../../_include/css/backend/editcontent.css");
define("CSSB_HEADER", "../../_include/css/backend/header.css");
define("CSSB_LOGIN", "../../_include/css/backend/login.css");
define("CSSB_POPUP", "../../_include/css/backend/popup.css");
define("CSSB_CSV", "../../_include/css/backend/uploadcsv.css");
//frontend CSS FILES:
define("CSSF_COMPARISON", "../../_include/css/frontend/comparison.css");
define("CSSF_CONTACT", "../../_include/css/frontend/contact.css");
define("CSSF_DEFAULT", "../../_include/css/frontend/default.css");
define("CSSF_FAQ", "../../_include/css/frontend/faq.css");
define("CSSF_HEADER", "../../_include/css/frontend/header.css");
define("CSSF_HELPTEXT", "../../_include/css/frontend/helptext.css");
define("CSSF_HOME", "../../_include/css/frontend/home.css");
define("CSSF_LISTVIEW", "../../_include/css/frontend/listview.css");
define("CSSF_MAPVIEW", "../../_include/css/frontend/mapview.css");
define("CSSF_PROFILE", "../../_include/css/frontend/profile.css");
define("CSSF_SCHOOLUPDATE", "../../_include/css/frontend/schoolupdate.css");
define("CSSF_SELECTION", "../../_include/css/frontend/selection.css");
define("CSSF_TILEVIEW", "../../_include/css/frontend/tileview.css");

//image paths:
//backend IMAGES:
define("BACKEND_IMAGES_PATH", "../../_include/imgBackend/");
//frontend IMAGES:
define("FRONTEND_IMAGES_PATH", "../../_include/imgFrontend/");

//Logo IMAGES
define("LOGO_IMAGES_PATH", "../../_include/schoolLogos/");
define("LOGO_IMAGES_PATH2", FRONTEND_LINK_ROOT."_include/schoolLogos/");
define("LOGO_IMAGES_PATH3", "../_include/schoolLogos/");

?>