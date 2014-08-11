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
$currentPage = 'contentManagement';
$rights = $checkUser->checkRights($_SESSION['authcode'], $_SESSION['uname'], $currentPage);
if($rights == 'VIEW_EDIT_FALSE') {
    if($_SESSION["lastpage"] == '') { $_SESSION["lastpage"] = 'overview'; }
    header('Location:'.$_SESSION["lastpage"]);
}
$_SESSION["lastpage"] = $currentPage;
//$siteRequest = explode('/', $_SERVER['REQUEST_URI']); 
//$actionRequest = $siteRequest[3];
//$actionArray = explode('&', $actionRequest);
//$action = $actionArray[0];
//$o=0;
//if($actionArray[0] == 'remove') {
//    unset($actionArray[0]);
//    $p=1;
//}
//else { $p=0; }
//foreach($actionArray as $value) {
//    $performOn[$o] = $actionArray[$p];
//    $o++;
//    $p++;
//}
$vorigeURL = BACKEND_LINK_ROOT.'contentManagement';
//if(isset($_POST['removesubmit'])) {
//    unset($_POST['removesubmit']);
//    foreach($_POST as $value) {
//        $actionParts = preg_split('#(?<=[a-z])(?=\d)#i', $value);
//        if($actionParts[0] == 'Category') {
//            $getFunction = 'removeCategory';
//        }
//        elseif($actionParts[0] == 'MenuCategory') {
//            $getFunction = 'removeMenuCategory';
//        }
//        elseif($actionParts[0] == 'Page') {
//            $getFunction = 'removePage';
//        }
//        elseif($actionParts[0] == 'Criteria') {
//            $getFunction = 'removeCriterium';
//        }
//        $remove = new BaseModel;
//        $removeItem = $remove->delItem($getFunction, $actionParts[1]);
//    }
//    header('Location:'.BACKEND_LINK_ROOT.'contentManagement');
//    $getFunction = "removeItemSchool";
//    foreach($_POST as $value) {
//        $remove = new BaseModel;
//        $removeItem = $remove->delItem($getFunction, $value);
//    }
//    header('Location:'.BACKEND_LINK_ROOT.'contentManagement');
//}
//if(isset($_POST['deleteSeveral'])) {
//    unset($_POST['deleteSeveral']);
//    $i=0;
//    foreach($_POST as $value) {
//        $putinURL[$i] = $value;
//        $i++;
//    }
//    $goToURL = implode("&", $putinURL);
//    header('Location:'.BACKEND_LINK_ROOT.'contentManagement/'.$goToURL);
//}

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
        <?php if($action != '') { ?>
             <div id="POPUP">
                    Weet u zeker dat u dit artikel wil verwijderen?<br/>
                    <?php echo '<form action="'.BACKEND_LINK_ROOT.'contentManagement/" method="POST">'; 
                    $l=0;
                    foreach($performOn as $value) { 
                        $actionParts = preg_split('#(?<=[a-z])(?=\d)#i', $value);
                        ?><br/> <?php echo $actionParts[0]; ?>:&nbsp;&nbsp;   <b><?php echo $actionParts[1]; ?></b><?php
                        echo '<input type="hidden" name="'.$l.'" value="'.$actionParts[0].$actionParts[1].'"/>';
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
                <?php if($sub != 'categories' && $sub != '') {} else { ?>
                <div id="tablecontainer">
                    <div class="tableheader">
                        <div class="tableheadername"><?php echo '<a href="'.BACKEND_LINK_ROOT.'contentManagement/categories">Article Categories</a>'; ?></div>
                        <?php if($rights == 'EDIT_TRUE') { ?>

                        <?php } else {} ?>
                    </div>
                    <div class="columnheaders">
                        <div class="column6header"></div>
                        <div class="column1header">Naam </div>     
                        <div class="column9header">Options</div>
                        <div class="column8header">Status</div>
                        <div class="column2header">ID</div>
                    </div>
                <?php 
                    $getFunction = 'getArticleCategories';
                    $articleitems = new BaseModel;
                    $article = $articleitems->showItems($getFunction); 
                    $i = 0;
                    foreach($article as $value) { ?>
                        <div class="tablerow1">
                            <div class="column6">
                                <input type="CHECKBOX" name="<?php echo "Category".$article[$i]["categoryID"]; ?>" value="<?php echo 'Category'.$article[$i]["categoryID"]; ?>">
                            </div>
                            <div class="column1">
                                <?php echo '<a href="'.BACKEND_LINK_ROOT.'contentManagementDetail/'.$article[$i]["menuCategoryID"].'-MenuCategory">'; 
                                    print_r($article[$i]["categoryName"]);
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
                                            echo '<img src="'.BACKEND_IMAGES_PATH.'remove.png" alt="delete" class="imagelink" />'; 

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
                                        if($rights == 'EDIT_TRUE') {
                                            echo '<img src="'.BACKEND_IMAGES_PATH.'lockedgrey.png" alt="not locked" class="imagelink" />'; 
                                        }
                                        else {
                                            echo '<img src="'.BACKEND_IMAGES_PATH.'locked.png" alt="locked" class="imagelink" />'; 
                                        }
                                    ?>
                                </div>
                                <div class="partialoption">
                                    <?php 
                                        echo '<img src="'.BACKEND_IMAGES_PATH.'flaggedgrey.png" alt="locked" class="imagelink" />';
                                    ?>
                                </div>
                            </div>
                            <div class="column2"><?php print_r($article[$i]["categoryID"]); ?></div>
                        </div>

                <?php $i++; }
                ?>
                </div>
                            ...
                <?php } ?>
                <?php $i = 0; ?>
                <?php if($sub != 'menuCategories' && $sub != '') {} else { ?>
                <div id="tablecontainer">
                    <div class="tableheader">
                        <div class="tableheadername"><?php echo '<a href="'.BACKEND_LINK_ROOT.'contentManagement/menuCategories">Menu Categories</a>'; ?></div>
                        <?php if($rights == 'EDIT_TRUE') { ?>
                            <div class="tableheaderoption">
                                <?php //echo '<img src="'.BACKEND_IMAGES_PATH.'headercopy.png" alt="copy" />'; ?>
                            </div>
                            <div class="tableheaderoption">
                                <?php //echo '<img src="'.BACKEND_IMAGES_PATH.'headernew.png" alt="new" />'; ?>
                            </div>
                            <div class="tableheaderoption">
<!--                                <input type="submit" name="deleteSeveral" value="" id="formdeletebutton" style="cursor:pointer;" />-->
                                <?php //echo '<img src="'.BACKEND_IMAGES_PATH.'headerdelete.png" alt="delete" />'; ?>
                            </div>
                        <?php } else {} ?>
                    </div>
                    <div class="columnheaders">
                        <div class="column6header"></div>
                        <div class="column1header">Naam </div>     
                        <div class="column9header">Options</div>
                        <div class="column8header">Status</div>
                        <div class="column2header">ID</div>
                        <div class="column3headerwide">Categorie</div>
                    </div>
                <?php 
                    $getFunction = 'getMenuCategories';
                    $articleitems = new BaseModel;
                    $article = $articleitems->showItems($getFunction); 
                    $i = 0;
                    foreach($article as $value) { ?>
                        <div class="tablerow1">
                            <div class="column6">
                                <input type="CHECKBOX" name="<?php echo "MenuCategory".$article[$i]["menuCategoryID"]; ?>" value="<?php echo 'MenuCategory'.$article[$i]["menuCategoryID"]; ?>">
                            </div>
                            <div class="column1">
                                <?php print_r($article[$i]["categoryName"]); ?>
                            </div>
                            <div class="column9">
                                <div class="partialoption">
                                    <?php echo '<img src="'.BACKEND_IMAGES_PATH.'editgrey.png" alt="delete" class="imagelink" />'; ?>
                                </div>
                                <div class="partialoption">
                                    <?php echo '<img src="'.BACKEND_IMAGES_PATH.'removegrey.png" alt="delete" class="imagelink" />'; ?>
                                </div>
                            </div>
                            <div class="column8">
                                <div class="partialoption">
                                    <?php 
                                        if($rights == 'EDIT_TRUE') {
                                            echo '<img src="'.BACKEND_IMAGES_PATH.'locked.png" alt="not locked" class="imagelink" />'; 
                                        }
                                        else {
                                            echo '<img src="'.BACKEND_IMAGES_PATH.'locked.png" alt="locked" class="imagelink" />'; 
                                        }
                                    ?>
                                </div>
                                <div class="partialoption">
                                    <?php 
                                        echo '<img src="'.BACKEND_IMAGES_PATH.'flaggedgrey.png" alt="locked" class="imagelink" />';
                                    ?>
                                </div>
                            </div>
                            <div class="column2"><?php print_r($article[$i]["menuCategoryID"]); ?></div>
                            <div class="column3wide"><?php print_r($article[$i]["imageFolderPath"]); ?></div>
                        </div>

                <?php $i++; }
                ?>
                </div>
                ...
                <?php } ?>
                <?php $i = 0; ?>
                <?php if($sub != 'pages' && $sub != '') {} else { ?>
                <div id="tablecontainer">
                    <div class="tableheader">
                        <div class="tableheadername"><?php echo '<a href="'.BACKEND_LINK_ROOT.'contentManagement/pages">Pages</a>'; ?></div>
                        <?php if($rights == 'EDIT_TRUE') { ?>
                            <div class="tableheaderoption">
                                <?php //echo '<img src="'.BACKEND_IMAGES_PATH.'headercopy.png" alt="copy" />'; ?>
                            </div>
                            <div class="tableheaderoption">
                                <?php //echo '<img src="'.BACKEND_IMAGES_PATH.'headernew.png" alt="new" />'; ?>
                            </div>
                            <div class="tableheaderoption">
<!--                                <input type="submit" name="deleteSeveral" value="" id="formdeletebutton" style="cursor:pointer;" />-->
                                <?php //echo '<img src="'.BACKEND_IMAGES_PATH.'headerdelete.png" alt="delete" />'; ?>
                            </div>
                        <?php } else {} ?>
                    </div>
                    <div class="columnheaders">
                        <div class="column6header"></div>
                        <div class="column1header">Naam </div>     
                        <div class="column9header">Options</div>
                        <div class="column8header">Status</div>
                        <div class="column2header">ID</div>
                    </div>
                <?php 
                    $getFunction = 'getPages';
                    $articleitems = new BaseModel;
                    $article = $articleitems->showItems($getFunction); 
                    $i = 0;
                    foreach($article as $value) { ?>
                        <div class="tablerow1">
                            <div class="column6">
                                <input type="CHECKBOX" name="<?php echo "Page".$article[$i]["pageID"]; ?>" value="<?php echo 'Page'.$article[$i]["pageID"]; ?>">
                            </div>
                            <div class="column1">
                                <?php print_r($article[$i]["pageName"]); ?>
                            </div>
                            <div class="column9">
                                <div class="partialoption">
                                    <?php echo '<img src="'.BACKEND_IMAGES_PATH.'editgrey.png" alt="delete" class="imagelink" />'; ?>
                                </div>
                                <div class="partialoption">
                                    <?php echo '<img src="'.BACKEND_IMAGES_PATH.'removegrey.png" alt="delete" class="imagelink" />'; ?>
                                </div>
                            </div>
                            <div class="column8">
                                <div class="partialoption">
                                    <?php 
                                        if($rights == 'EDIT_TRUE') {
                                            echo '<img src="'.BACKEND_IMAGES_PATH.'locked.png" alt="not locked" class="imagelink" />'; 
                                        }
                                        else {
                                            echo '<img src="'.BACKEND_IMAGES_PATH.'locked.png" alt="locked" class="imagelink" />'; 
                                        }
                                    ?>
                                </div>
                                <div class="partialoption">
                                    <?php 
                                        echo '<img src="'.BACKEND_IMAGES_PATH.'flaggedgrey.png" alt="locked" class="imagelink" />';
                                    ?>
                                </div>
                            </div>
                            <div class="column2"><?php print_r($article[$i]["pageID"]); ?></div>
                        </div>

                <?php $i++; }
                ?>
                </div>
                ...
                <?php $i = 0; ?>
                <?php } ?>  
                <?php if($sub != 'criteria' && $sub != '') {} else { ?>
                <div id="tablecontainer">
                    <div class="tableheader">
                        <div class="tableheadername"><?php echo '<a href="'.BACKEND_LINK_ROOT.'contentManagement/criteria">Criteria</a>'; ?></div>
                        <?php if($rights == 'EDIT_TRUE') { ?>
                            <div class="tableheaderoption">
                                <?php //echo '<img src="'.BACKEND_IMAGES_PATH.'headercopy.png" alt="copy" />'; ?>
                            </div>
                            <div class="tableheaderoption">
                                <?php //echo '<img src="'.BACKEND_IMAGES_PATH.'headernew.png" alt="new" />'; ?>
                            </div>
                            <div class="tableheaderoption">
<!--                                <input type="submit" name="deleteSeveral" value="" id="formdeletebutton" style="cursor:pointer;" />-->
                                <?php //echo '<img src="'.BACKEND_IMAGES_PATH.'headerdelete.png" alt="delete" />'; ?>
                            </div>
                        <?php } else {} ?>
                    </div>
                    <div class="columnheaders">
                        <div class="column6header"></div>
                        <div class="column1header">Naam </div>     
                        <div class="column9header">Options</div>
                        <div class="column8header">Status</div>
                        <div class="column2header">ID</div>
                    </div>
                <?php 
                    $getFunction = 'getCriteriaTypes';
                    $articleitems = new BaseModel;
                    $article = $articleitems->showItems($getFunction); 
                    $i = 0;
                    foreach($article as $value) { ?>
                        <div class="tablerow1">
                            <div class="column6">
                                <input type="CHECKBOX" name="<?php echo "Criteria".$article[$i]["criteriaType"]; ?>" value="<?php echo 'Criteria'.$article[$i]["criteriaType"]; ?>">
                            </div>
                            <div class="column1">
                                <?php echo '<a href="'.BACKEND_LINK_ROOT.'contentManagementDetail/'.$article[$i]["criteriaType"].'-Criteria">'; 
                                    print_r($article[$i]["criteriaName"]);
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
                                            echo '<img src="'.BACKEND_IMAGES_PATH.'remove.png" alt="delete" class="imagelink" />'; 

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
                                        if($rights == 'EDIT_TRUE') {
                                            echo '<img src="'.BACKEND_IMAGES_PATH.'lockedgrey.png" alt="not locked" class="imagelink" />'; 
                                        }
                                        else {
                                            echo '<img src="'.BACKEND_IMAGES_PATH.'locked.png" alt="locked" class="imagelink" />'; 
                                        }
                                    ?>
                                </div>
                                <div class="partialoption">
                                    <?php 
                                        echo '<img src="'.BACKEND_IMAGES_PATH.'flaggedgrey.png" alt="locked" class="imagelink" />';
                                    ?>
                                </div>
                            </div>
                            <div class="column2"><?php print_r($article[$i]["criteriaType"]); ?></div>
                        </div>

                <?php $i++; }
                ?>
                </div>
                ...
                <?php } ?>
            </div>
        </form>
    </body>
</html>