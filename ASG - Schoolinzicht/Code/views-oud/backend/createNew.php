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
$currentPage = 'createNew';
$pageContent = $_SESSION['lastpage'];
if(!empty($_SESSION['lastpage-extra'])) {
    $pageContent = $_SESSION['lastpage-extra'];
    unset($_SESSION['lastpage-extra']);
}
//$_SESSION["lastpage"] = $currentPage;

$vorigeURL = BACKEND_LINK_ROOT.'articleList';

    $getFunction = 'getArticleCategories';
    $itemDetails = new BaseModel;
    $itemDetails2 = $itemDetails->showItems($getFunction);
    
    $getFunction = 'getArticlePages';
    $itemDetails = new BaseModel;
    $itemDetails3 = $itemDetails->showItems($getFunction);
    
    if(isset($_POST['create-article'])) {
        unset($_POST['create-article']);
        unset($_POST['creationDate']);
        unset($_POST['modifiedBy']);
        unset($_POST['modifyDate']);
        $_POST['author'] = strtolower($_POST['author']);
        $_POST['creationDate'] = date("Y-m-d H:i:s");
        $addFunction = 'addContentArticle';
        $addArticle = new BaseModel;
        $addedArticle = $addArticle->addItem($addFunction, $_POST);
        empty($_POST);
    }
    elseif(isset($_POST['create-user'])) {
        $addFunction = 'addNewUser';
        $addUser = new BaseModel;
        $addedUser = $addUser->addItem($addFunction, $_POST);
        empty($_POST);
        $editSuccess = 'userAdded';
    }
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
        <?php if(isset($editSuccess)) { ?>
        <div id="contentcontainer">
            <div id="contenteditsucces">
                Het item is toegevoegd, 
                <?php echo '<a href="'.$vorigeURL.'">klik hier</a>'; ?>
                om terug te keren naar de overzichtspagina
            </div>
        </div>
        <?php
        }else { ?>
        <div id="contentcontainer">
            <div id="editcontentcontainer">
                <?php if($pageContent == 'articleList') { ?>
                <div id="editcontentleftrightcontainer">
                    <div id="editcontentleftcontainer">
                        <form name="article" action="" method="POST">
                        <div class="editcontentitem">
                            <div class="editcontentitemtitle">Article Title:</div>
                                <input type="text" name="title" class="editcontentitemcontent"  value="<?php echo $itemDetails1[0]["title"]; ?>" />
                        </div>
                        <div class="editcontentitem">
                            <div class="editcontentitemlongleft">
                                <div class="editcontentitemtitle">Article Body:</div>
                            </div>
                            <div class="editcontentitemlongright">
                                <textarea cols="1" rows="1" name="body" class="editcontentitemcontentlong"><?php echo $itemDetails1[0]["body"]; ?></textarea>
                            </div>
                        </div>
                        <div class="editcontentitem">
                            <div class="editcontentitemtitle">Article Author:</div>
                            <input type="text" name="author" class="editcontentitemcontentgrey" readonly="readonly" value="<?php echo $_SESSION['uname']; ?>" />
                        </div>
                        <div class="editcontentitem">
                            <div class="editcontentitemtitle">Creation Date:</div>
                            <input type="text" name="creationDate" class="editcontentitemcontentgrey" readonly="readonly" value="<?php echo date('d-m-Y'); ?>" />
                        </div>
                        <div class="editcontentitem">
                            <div class="editcontentitemtitle">Modified By:</div>
                            <input type="text" name="modifiedBy" class="editcontentitemcontentgrey" readonly="readonly" value="<?php echo $_SESSION['uname']; ?>" />
                        </div>
                        <div class="editcontentitem">
                            <div class="editcontentitemtitle">Modify Date:</div>
                            <input type="text" name="modifyDate" class="editcontentitemcontentgrey" readonly="readonly" value="<?php echo date('d-m-Y'); ?>" />
                        </div>
                            <div class="editcontentitem">
                                <div class="editcontentitemtitle">Category:</div>
                                <select class="standardselect" name="categoryID">
                                    <?php
                                        $i = '0';
                                        foreach($itemDetails2 as $value) {
                                            if($itemDetails2[$i]["categoryID"] == $itemDetails1[0]["categoryID"]) { ?>
                                                    <option SELECTED style="font-weight: bold" value="<?php echo $itemDetails2[$i]["categoryID"]; ?>">
                                                        <?php echo $itemDetails2[$i]["categoryName"]; ?>
                                                    </option>
                                            <?php $i++;}

                                            else { ?>
                                                <option value="<?php echo $itemDetails2[$i]["categoryID"]; ?>">
                                                    <?php echo $itemDetails2[$i]["categoryName"]; ?>
                                                </option>
                                            <?php
                                            $i++;
                                            }
                                         } ?>
                                </select>
                            </div>
                            <div class="editcontentitem">
                                <div class="editcontentitemtitle">Page:</div>
                                <select class="standardselect" name="pageID">
                                    <?php
                                    $i = '0';
                                        foreach($itemDetails3 as $value) {
                                            if($itemDetails3[$i]["pageID"] == $itemDetails1[0]["pageID"]) { ?>
                                                    <option SELECTED style="font-weight: bold" value="<?php echo $itemDetails3[$i]["pageID"]; ?>">
                                                        <?php echo $itemDetails3[$i]["pageName"]; ?>
                                                    </option>
                                            <?php $i++;}

                                            else { ?>
                                                <option value="<?php echo $itemDetails3[$i]["pageID"]; ?>">
                                                    <?php echo $itemDetails3[$i]["pageName"]; ?>
                                                </option>
                                            <?php
                                            $i++;
                                            }
                                        }
                                    ?>
                                </select>
                            </div> 
                       <?php echo '<a href="'.$vorigeURL.'" class="editpagecancel">ANNULEREN</a>'; ?>
                       
                       <input style="cursor: pointer;" type="submit" name="create-article" value="OPSLAAN" class="editpagesubmit"/>
                    </form>
                    </div>
                    <div id="editcontentrightcontainer">
<!--                        <div class="flagitemcontainer">
                            <div class="flagitemtop">
                                <div class="flagitemname">
                                    <div class="flagitemnameimage">
                                        <?php //echo '<img src="../'.BACKEND_IMAGES_PATH.'flagged.png" alt="" class="img" />'; ?>
                                    </div>
                                    <div class="flagitemnametext">FLAG <i>(plaats een opmerking)</i></div>
                                </div>
                                <div class="flagitemremaining">4/500</div>
                                <div class="flagitemdelete">
                                    <?php //echo '<img src="../'.BACKEND_IMAGES_PATH.'remove.png" alt="" class="img" />'; ?>
                                </div>
                            </div>
                            <textarea cols="1" rows="1" class="flagitemcontent">test</textarea>
                        </div>
                        <div class="flagitemcontainer">
                            <div class="flagitemtop">
                                <div class="flagitemname">
                                    <div class="flagitemnameimage">
                                        <?php //echo '<img src="../'.BACKEND_IMAGES_PATH.'flagged.png" alt="" class="img" />'; ?>
                                    </div>
                                    <div class="flagitemnametext">FLAG <i>(plaats een opmerking)</i></div>
                                </div>
                                <div class="flagitemremaining">7/500</div>
                                <div class="flagitemdelete">
                                    <?php //echo '<img src="../'.BACKEND_IMAGES_PATH.'remove.png" alt="" class="img" />'; ?>
                                </div>
                            </div>
                            <textarea cols="1" rows="1" class="flagitemcontent">testing</textarea>
                        </div>-->
                    </div>
                </div>
                <?php } elseif($pageContent == 'userList') { ?>
                <form name="user" action="" method="POST">
                    <div id="editcontentleftrightcontainer">
                        <div id="editcontentleftcontainer">
                                <div class="editcontentitem">
                                    <div class="editcontentitemtitle">Username:</div>
                                    <input type="text" name="name" class="editcontentitemcontent" value="" />
                                </div>
                                <div class="editcontentitem">
                                    <div class="editcontentitemtitle">Password:</div>
                                    <input type="text" name="password" readonly="readonly" class="editcontentitemcontentgrey"  value="asg" />
                                </div>
                                <div class="editcontentitem">
                                    <div class="editcontentitemtitle">E-mailaddress:</div>
                                    <input type="text" name="emailAddress" class="editcontentitemcontent" value="" />
                                </div>
                                <div class="editcontentitem">
                                    <div class="editcontentitemtitle">Userlevel:</div>
                                    <input type="text" name="accessLevel" class="editcontentitemcontent" value="" />
                                </div>
                             <?php echo '<a href="'.$vorigeURL.'" class="editpagecancel">ANNULEREN</a>'; ?>
                            <input style="cursor: pointer;" type="submit" name="create-user" value="OPSLAAN" class="editpagesubmit"/>
                        </div>
                    </div>
                </form>
                <?php } ?>
            </div>
            ...
        </div>
        <?php } ?>
    </body>
</html>