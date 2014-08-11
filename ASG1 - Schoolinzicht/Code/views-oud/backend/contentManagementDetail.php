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
$currentPage = 'contentManagementDetail';
$rights = $checkUser->checkRights($_SESSION['authcode'], $_SESSION['uname'], $currentPage);
if($rights == 'VIEW_EDIT_FALSE') {
    if($_SESSION["lastpage"] == '') { $_SESSION["lastpage"] = 'overview'; }
    header('Location:'.$_SESSION["lastpage"]);
}
$_SESSION["lastpage"] = $currentPage;
$vorigeURL = BACKEND_LINK_ROOT.'contentManagement';
$uname = $_SESSION['uname'];
//dit zou uit de session ($_SESSION['accessLevel']) moeten komen:
$userAccessLevel = '0';
$editFunction = 'editArticle';
if(isset($_POST[editpagesubmit])) {
    foreach($_POST as $value) {
        $formValues[0] = $_POST;
    }
    $editedInfo = new BaseModel;
    $editSuccess = $editedInfo->editItem($editFunction, $formValues, $uname);
}
$array = explode('-',$_SERVER['REQUEST_URI']); 
array_shift($array); 
$type = $array[0];

?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <?php echo '<link rel="stylesheet" type="text/css" href="'.CSSB_DEFAULT.'" />'; ?>
        <?php echo '<link rel="stylesheet" type="text/css" href="'.CSSB_HEADER.'" />'; ?>
        <?php echo '<link rel="stylesheet" type="text/css" href="'.CSSB_EDITCONTENT.'" />'; ?>
        <?php if(isset($editSuccess)) { echo '<meta http-equiv="refresh" content="5; URL='.BACKEND_LINK_ROOT.'articleList">'; } else { } ?>
        <title>SCHOOLINZICHT - Backend</title>
    </head>
    <body class="body">        
        <?php include_once("views/components/backendHeader.php"); ?>
<?php
    $idArray = explode('/',$_SERVER['REQUEST_URI']); 
    array_shift($idArray); 
    $id = $idArray[2];
    if($type == 'Criteria') { $type = 'Criterium'; } else {} 
    $getFunction = 'get'.$type;
    $itemDetails = new BaseModel;
    $itemDetails1 = $itemDetails->showItem($getFunction,$id);
?>
        <?php if(isset($editSuccess)) {  ?>
        <div id="contentcontainer">
            <div id="contenteditsucces">
                Het <?php echo '<a href="'.BACKEND_LINK_ROOT.'articleDetail/'.$id.'">artikel</a>'; ?> is aangepast, 
                <?php echo '<a href="'.$vorigeURL.'">klik hier</a>'; ?>
                om terug te keren naar de overzichtspagina
                <br/>
                
                of wacht 5 seconden voor een automatische redirect naar de overzichtspagina
                <?php $huppeldepup = 'test'; ?>
            </div>
        </div>
        <?php } elseif($huppeldepup == 'test') {
            $time=5; sleep($time); header('Location: '.BACKEND_LINK_ROOT.'articleList');   
        }else { ?>
            <?php 
            if($type == 'Category') { 
                ?>
        <div id="contentcontainer">
            <div id="editcontentcontainer">
                <div id="editcontentleftrightcontainer">
                    <div id="editcontentleftcontainer">
                        <form action="" method="POST">
                            <?php
                                if($rights == 'EDIT_TRUE') {}
                                else {
                                    ?>
                                    <div class="editcontentitem">
                                        <div class="editcontentitemtitle"><u>LET OP!</u></div>
                                        <input type="text" name="ArticleAuthor" class="editcontentitemcontentred" readonly="readonly" value="U BENT NIET BEVOEGD OM DIT ARTIKEL AAN TE PASSEN" />
                                    </div>
                                    <?php
                                }
                            ?>
                        <div class="editcontentitem">
                            <div class="editcontentitemtitle">Article ID:</div>
                            <input type="text" name="artID" class="editcontentitemcontentgrey" readonly="readonly" value="<?php echo $itemDetails1[0]["categoryID"]; ?>" />
                        </div>
                        <div class="editcontentitem">
                            <div class="editcontentitemtitle">Article Title:</div>
                            <?php
                                if($rights == 'EDIT_TRUE') {
                                    ?><input type="text" name="title" class="editcontentitemcontent"  value="<?php echo $itemDetails1[0]["categoryName"]; ?>" /><?php
                                }
                                else {
                                    ?><input type="text" name="title" class="editcontentitemcontentgrey" readonly="readonly" value="<?php echo $itemDetails1[0]["categoryName"]; ?>" /><?php
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            
                    <?php
            }
            elseif($type == 'MenuCategory') {
             ?>
                <div id="contentcontainer">
                    <div id="editcontentcontainer">
                        <div id="editcontentleftrightcontainer">
                            <div id="editcontentleftcontainer">
                                <form action="" method="POST">
                                    <?php
                                        if($userAccessLevel <= $itemDetails1[0]["accessLevel"]) {}
                                        else {
                                            ?>
                                            <div class="editcontentitem">
                                                <div class="editcontentitemtitle"><u>LET OP!</u></div>
                                                <input type="text" name="ArticleAuthor" class="editcontentitemcontentred" readonly="readonly" value="U BENT NIET BEVOEGD OM DIT ARTIKEL AAN TE PASSEN" />
                                            </div>
                                            <?php
                                        }
                                    ?>
                                <div class="editcontentitem">
                                    <div class="editcontentitemtitle">Article ID:</div>
                                    <input type="text" name="artID" class="editcontentitemcontentgrey" readonly="readonly" value="<?php echo $itemDetails1[0]["menuCategoryID"]; ?>" />
                                </div>
                                <div class="editcontentitem">
                                    <div class="editcontentitemtitle">Article Title:</div>
                                    <?php
                                        if($userAccessLevel <= $itemDetails1[0]["accessLevel"]) {
                                            ?><input type="text" name="title" class="editcontentitemcontent"  value="<?php echo $itemDetails1[0]["categoryName"]; ?>" /><?php
                                        }
                                        else {
                                            ?><input type="text" name="title" class="editcontentitemcontentgrey" readonly="readonly" value="<?php echo $itemDetails1[0]["categoryName"]; ?>" /><?php
                                        }
                                    ?>
                                </div>
                                <div class="editcontentitem">
                                    <div class="editcontentitemtitle">Image Location:</div>
                                    <?php
                                        if($userAccessLevel <= $itemDetails1[0]["accessLevel"]) {
                                            ?><input type="text" name="title" class="editcontentitemcontent"  value="<?php echo $itemDetails1[0]["imageFolderPath"]; ?>" /><?php
                                        }
                                        else {
                                            ?><input type="text" name="title" class="editcontentitemcontentgrey" readonly="readonly" value="<?php echo $itemDetails1[0]["imageFolderPath"]; ?>" /><?php
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                     <?php
            }
            elseif($type == 'Page') {
                ?>
                <div id="contentcontainer">
                    <div id="editcontentcontainer">
                        <div id="editcontentleftrightcontainer">
                            <div id="editcontentleftcontainer">
                                <form action="" method="POST">
                                    <?php
                                        if($userAccessLevel <= $itemDetails1[0]["accessLevel"]) {}
                                        else {
                                            ?>
                                            <div class="editcontentitem">
                                                <div class="editcontentitemtitle"><u>LET OP!</u></div>
                                                <input type="text" name="ArticleAuthor" class="editcontentitemcontentred" readonly="readonly" value="U BENT NIET BEVOEGD OM DIT ARTIKEL AAN TE PASSEN" />
                                            </div>
                                            <?php
                                        }
                                    ?>
                                <div class="editcontentitem">
                                    <div class="editcontentitemtitle">Article ID:</div>
                                    <input type="text" name="artID" class="editcontentitemcontentgrey" readonly="readonly" value="<?php echo $itemDetails1[0]["pageID"]; ?>" />
                                </div>
                                <div class="editcontentitem">
                                    <div class="editcontentitemtitle">Article Title:</div>
                                    <?php
                                        if($userAccessLevel <= $itemDetails1[0]["accessLevel"]) {
                                            ?><input type="text" name="title" class="editcontentitemcontent"  value="<?php echo $itemDetails1[0]["pageName"]; ?>" /><?php
                                        }
                                        else {
                                            ?><input type="text" name="title" class="editcontentitemcontentgrey" readonly="readonly" value="<?php echo $itemDetails1[0]["pageName"]; ?>" /><?php
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                     <?php
            }
            elseif($type == 'Criterium') {
                ?>
                <div id="contentcontainer">
                    <div id="editcontentcontainer">
                        <div id="editcontentleftrightcontainer">
                            <div id="editcontentleftcontainer">
                                <form action="" method="POST">
                                <?php
                                    if($rights == 'EDIT_TRUE') {}
                                    else {
                                        ?>
                                        <div class="editcontentitem">
                                            <div class="editcontentitemtitle"><u>LET OP!</u></div>
                                            <input type="text" name="ArticleAuthor" class="editcontentitemcontentred" readonly="readonly" value="U BENT NIET BEVOEGD OM DIT ARTIKEL AAN TE PASSEN" />
                                        </div>
                                        <?php
                                    }
                                ?>
                                <div class="editcontentitem">
                                    <div class="editcontentitemtitle">Article ID:</div>
                                    <input type="text" name="artID" class="editcontentitemcontentgrey" readonly="readonly" value="<?php echo $itemDetails1[0]["criteriaType"]; ?>" />
                                </div>
                                <div class="editcontentitem">
                                    <div class="editcontentitemtitle">Article Title:</div>
                                    <?php
                                        if($rights == 'EDIT_TRUE') {}
                                            ?><input type="text" name="title" class="editcontentitemcontent" readonly="readonly" value="<?php echo $itemDetails1[0]["criteriaName"]; ?>" /><?php
                                        }
                                        else {
                                            ?><input type="text" name="title" class="editcontentitemcontentgrey" readonly="readonly" value="<?php echo $itemDetails1[0]["criteriaName"]; ?>" /><?php
                                        }
                                        $getFunction = 'getFullCriteriaValues';
                                        $criteriaValues = $itemDetails->showItem($getFunction,$itemDetails1[0]["criteriaType"]);
                                        $i=0;
                                        foreach($criteriaValues as $value) {
                                            if($rights == 'EDIT_TRUE') { ?>
                                                <div class="editcontentitem">
                                                    <div class="editcontentitemtitle">Value Name:</div>
                                                    <input type="text" name="title" class="editcontentitemcontentgrey" readonly="readonly" value="<?php echo $criteriaValues[$i]["criteriaValueName"]; ?>" />
                                                </div>
                                                <div class="editcontentitem">
                                                    <div class="editcontentitemtitle">Value:</div>
                                                    <input type="text" name="title" class="editcontentitemcontentgrey" readonly="readonly" value="<?php echo $criteriaValues[$i]["criteriaValue"]; ?>" />
                                                </div>
                                           <?php    }
                                            else { ?>
                                                <div class="editcontentitem">
                                                    <div class="editcontentitemtitle">Value Name:</div>
                                                    <input type="text" name="title" class="editcontentitemcontentgrey" readonly="readonly" value="<?php echo $criteriaValues[$i]["criteriaValueName"]; ?>" />
                                                </div>
                                                <div class="editcontentitem">
                                                    <div class="editcontentitemtitle">Value:</div>
                                                    <input type="text" name="title" class="editcontentitemcontentgrey" readonly="readonly" value="<?php echo $criteriaValues[$i]["criteriaValue"]; ?>" />
                                                </div>
                                            <?php }
                                            $i++;
                                        }
                                    ?>
                                </div>
                            </div>
                     <?php
            }
            ?>
                    <div id="editcontentrightcontainer">
<!--                        <div class="flagitemcontainer">
                            <div class="flagitemtop">
                                <div class="flagitemname">
                                    <div class="flagitemnameimage">
                                        <?php echo '<img src="../'.BACKEND_IMAGES_PATH.'flagged.png" alt="" class="img" />'; ?>
                                    </div>
                                    <div class="flagitemnametext">FLAG <i>(plaats een opmerking)</i></div>
                                </div>
                                <div class="flagitemremaining">4/500</div>
                                <div class="flagitemdelete">
                                    <?php echo '<img src="../'.BACKEND_IMAGES_PATH.'remove.png" alt="" class="img" />'; ?>
                                </div>
                            </div>
                            <textarea cols="1" rows="1" class="flagitemcontent">test</textarea>
                        </div>
                        <div class="flagitemcontainer">
                            <div class="flagitemtop">
                                <div class="flagitemname">
                                    <div class="flagitemnameimage">
                                        <?php echo '<img src="../'.BACKEND_IMAGES_PATH.'flagged.png" alt="" class="img" />'; ?>
                                    </div>
                                    <div class="flagitemnametext">FLAG <i>(plaats een opmerking)</i></div>
                                </div>
                                <div class="flagitemremaining">7/500</div>
                                <div class="flagitemdelete">
                                    <?php echo '<img src="../'.BACKEND_IMAGES_PATH.'remove.png" alt="" class="img" />'; ?>
                                </div>
                            </div>
                            <textarea cols="1" rows="1" class="flagitemcontent">testing</textarea>
                        </div>-->
                    </div>
                </div>
            </div>
            ...
        </div>
    </body>
</html>