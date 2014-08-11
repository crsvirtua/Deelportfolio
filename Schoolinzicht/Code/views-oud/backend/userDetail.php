<?php

//Designed and written in the year 2012, for ASG, by:
//Peter van Kleef, Richard Floris & Pepijn de Vries.

session_start();
require_once MODEL_USER;
    
$checkUser = new User;
$authUser = $checkUser->authenticateUser($_SESSION['uname'], $_SESSION['authcode']);

if($authUser == 'authUnSucc') { 
    session_destroy();
    header('Location: '.BACKEND_LINK_ROOT);
} else {}

//determine what rights this user has on this page:
$currentPage = 'userList';
$rights = $checkUser->checkRights($_SESSION['authcode'], $_SESSION['uname'], $currentPage);
if($rights == 'VIEW_EDIT_FALSE') {
    if($_SESSION["lastpage"] == '') { $_SESSION["lastpage"] = 'overview'; }
    header('Location:'.$_SESSION["lastpage"]);
}
$_SESSION["lastpage"] = $currentPage;

    $idArray = explode('/',$_SERVER['REQUEST_URI']); 
    array_shift($idArray); 
    $userID = $idArray[2];
    $userInfo = $checkUser->getUserDetail($userID);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <?php echo '<link rel="stylesheet" type="text/css" href="'.CSSB_DEFAULT.'" />'; ?>
        <?php echo '<link rel="stylesheet" type="text/css" href="'.CSSB_HEADER.'" />'; ?>
        <?php echo '<link rel="stylesheet" type="text/css" href="'.CSSB_EDITCONTENT.'" />'; ?>
        <title>SCHOOLINZICHT - Backend</title>
    </head>
    <body class="body">        
        <?php include_once("views/components/backendHeader.php"); ?>
        <div id="contentcontainer">
            <div id="editcontentcontainer">
                <div id="editcontentleftrightcontainer">
                    <div id="editcontentleftcontainer">
                        <form action="" method="POST">
                            <div class="editcontentitem">
                                <div class="editcontentitemtitle">Username:</div>
                                <input type="text" name="artID" class="editcontentitemcontentgrey" value="<?php echo $userInfo[0]["name"]; ?>" />
                            </div>
                            <div class="editcontentitem">
                                <div class="editcontentitemtitle">Password:</div>
                                <input type="password" name="title" class="editcontentitemcontent"  value="<?php echo $userInfo[0]["password"]; ?>" />
                            </div>
                            <div class="editcontentitem">
                                <div class="editcontentitemtitle">E-mailaddress:</div>
                                <input type="text" name="author" class="editcontentitemcontentgrey" readonly="readonly" value="<?php echo $userInfo[0]["emailAddress"]; ?>" />
                            </div>
                            <div class="editcontentitem">
                                <div class="editcontentitemtitle">Userlevel:</div>
                                <input type="text" name="author" class="editcontentitemcontentgrey" readonly="readonly" value="<?php echo $userInfo[0]["accessLevel"]; ?>" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            ...
        </div>
    </body>
</html>