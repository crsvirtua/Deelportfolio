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
$currentPage = 'articleList';
$rights = $checkUser->checkRights($_SESSION['authcode'], $_SESSION['uname'], $currentPage);
if($rights == 'VIEW_EDIT_FALSE') {
    if($_SESSION["lastpage"] == '') { $_SESSION["lastpage"] = 'articleList'; }
    header('Location:'.BACKEND_LINK_ROOT.$_SESSION["lastpage"]);
}
$_SESSION["lastpage"] = $currentPage;

$siteRequest = explode('/', $_SERVER['REQUEST_URI']); 
$actionRequest = $siteRequest[3];
$actionArray = explode('&', $actionRequest);
$action = $actionArray[0];
$o=0;
if($actionArray[0] == 'remove') {
    unset($actionArray[0]);
    $p=1;
}
else { $p=0; }
foreach($actionArray as $value) {
    $performOn[$o] = $actionArray[$p];
    $o++;
    $p++;
}
$vorigeURL = BACKEND_LINK_ROOT.'articleList';
if(isset($_POST['removesubmit'])) {
    unset($_POST['removesubmit']);
    $getFunction = "removeItemSchool";
    foreach($_POST as $value) {
        $remove = new BaseModel;
        $removeItem = $remove->delItem($getFunction, $value);
    }
    header('Location:'.BACKEND_LINK_ROOT.'schoolList');
}
if(isset($_POST['deleteSeveral'])) {
    unset($_POST['deleteSeveral']);
    $i=0;
    foreach($_POST as $value) {
        $putinURL[$i] = $value;
        $i++;
    }
    $goToURL = implode("&", $putinURL);
    header('Location:'.BACKEND_LINK_ROOT.'articleList/'.$goToURL);
}

$getFunction = 'getArticles';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <?php echo '<link rel="stylesheet" type="text/css" href="'.CSSB_DEFAULT.'" />'; ?>
        <?php echo '<link rel="stylesheet" type="text/css" href="'.CSSB_HEADER.'" />'; ?>
        <?php if($action != '') {
             echo '<link rel="stylesheet" type="text/css" href="'.CSSB_POPUP.'" />'; 
        } ?>
        <title>SCHOOLINZICHT - Backend</title>
    </head>
    <body class="body">        
        <?php if($action == 'remove') { ?>
             <div id="POPUP">
                    Weet u zeker dat u deze artikelen wil verwijderen?<br/>
                    <?php echo '<form action="'.BACKEND_LINK_ROOT.'articleList/" method="POST">'; 
                    $l=0;
                    foreach($performOn as $value) { 
                        ?><br/> ID:&nbsp;&nbsp;   <b><?php print_r($value); ?></b><?php
                        echo '<input type="hidden" name="'.$l.'" value="'.$value.'"/>';
                        $l++;
                    }
                    ?>
                    <div id="popupbottom">
                         <?php echo '<a href="'.$vorigeURL.'" class="popupcancel">ANNULEREN</a>'; ?>
                        <input style="cursor: pointer;" type="submit" name="removesubmit" value="DOORGAAN" class="popupsubmit"/>
                    </div>
                    <?php echo "</form>"; ?>
             </div> 
             <div id="popupcontainer"></div>
        <?php } ?>
        <form action="" method="POST">
            <?php include_once("views/components/backendHeader.php"); ?>
            <div id="contentcontainer">
                <div id="tablecontainer">
                    <div class="tableheader">
                        <div class="tableheadername">ARTICLES</div>
                        <?php if($rights == 'EDIT_TRUE') { ?>
                            <div class="tableheaderoption">
                                <?php //echo '<img src="'.BACKEND_IMAGES_PATH.'headercopy.png" alt="copy" />'; ?>
                            </div>
                            <div class="tableheaderoption">
                                <?php echo '<a href="'.BACKEND_LINK_ROOT.'createNew"><img src="'.BACKEND_IMAGES_PATH.'headernew.png" alt="new" class="imagelink"/></a>'; ?>
                            </div>
                            <div class="tableheaderoption">
                                <input type="submit" name="deleteSeveral" value="" id="formdeletebutton" style="cursor:pointer;" />
                            </div>
                        <?php } else {} ?>
                    </div>
                    <div class="columnheaders">
                        <div class="column6header"></div>
                        <div class="column1header">Article </div>     
                        <div class="column9header">Options</div>
                        <div class="column8header">Status</div>
                        <div class="column7header">Published</div>
                        <div class="column5header">Last modified</div>
                        <div class="column4header">Creation date</div>
                        <div class="column3header">Location</div>
                        <div class="column2header">Category</div>
                    </div>
                <?php 
                    $articleitems = new BaseModel;
                    $article = $articleitems->showItems($getFunction); 
                    $i = 0;
                    foreach($article as $value) { ?>
                        <div class="tablerow1">
                            <div class="column6">
                                <input type="CHECKBOX" name="<?php echo $article[$i]["artID"]; ?>" value="<?php echo $article[$i]["artID"]; ?>">
                            </div>
                            <div class="column1">
                                <?php echo '<a href="'.BACKEND_LINK_ROOT.'articleDetail/'.$article[$i]["artID"].'">'; 
                                        print_r($article[$i]["title"]);
                                    echo '</a>';
                                ?>
                            </div>
                            <div class="column9">
                                <div class="partialoption">
                                    <?php echo '<a href="'.BACKEND_LINK_ROOT.'articleDetail/'.$article[$i]["artID"].'">';
                                        if($rights == 'EDIT_TRUE') {
                                            echo '<img src="'.BACKEND_IMAGES_PATH.'edit.png" alt="edit" class="imagelink" />'; 
                                        }
                                        else {
                                            echo '<img src="'.BACKEND_IMAGES_PATH.'view2.png" alt="edit" class="imagelink" height="11" width="14"/>';
                                        }
                                        echo '</a>'; ?>
                                </div>
                                <div class="partialoption">
                                    <?php 
                                        if($rights == 'EDIT_TRUE') {
                                            //moet nog een URL omheen:
                                            echo '<a href="'.BACKEND_LINK_ROOT.'articleList/remove&'.$article[$i]["artID"].'">';
                                                echo '<img src="'.BACKEND_IMAGES_PATH.'remove.png" alt="delete" class="imagelink" />'; 
                                            echo '</a>';
                                        }
                                        else {
                                            echo '<img src="'.BACKEND_IMAGES_PATH.'removegrey.png" alt="delete" class="imagelink" />'; 
                                        }
                                    ?>
                                </div>
                            </div>
                            <div class="column8">
                                <div class="partialoption">
                                    <?php 
                                        if($$rights == 'EDIT_TRUE') {
                                            echo '<img src="'.BACKEND_IMAGES_PATH.'locked.png" alt="not locked" class="imagelink" />'; 
                                        }
                                        else {
                                            echo '<img src="'.BACKEND_IMAGES_PATH.'lockedgrey.png" alt="locked" class="imagelink" />'; 
                                        }
                                    ?>
                                </div>
                                <div class="partialoption">
                                    <?php 
                                        echo '<img src="'.BACKEND_IMAGES_PATH.'flaggedgrey.png" alt="locked" class="imagelink" />';
                                    ?>
                                </div>
                            </div>
                            <div class="column7">yes</div>     
                            <div class="column5"><?php print_r($article[$i]["modifyDate"]); ?></div>
                            <div class="column4"><?php print_r($article[$i]["creationDate"]); ?></div>
                            <div class="column3"><?php print_r($article[$i]["pageName"]); ?></div>
                            <div class="column2"><?php print_r($article[$i]["categoryName"]); ?></div>
                        </div>
                <?php $i++; }
                ?>
                </div>
                ...
            </div>
        </form>
    </body>
</html>