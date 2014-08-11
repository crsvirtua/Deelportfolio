<?php

//Designed and written in the year 2012, for ASG, by:
//Peter van Kleef, Richard Floris & Pepijn de Vries.

session_start();
require_once MODEL_USER;

//IF the user is not logged in or the authenticationcode is not equal to the one in the DB:
$checkUser = new User;
$authUser = $checkUser->authenticateUser($_SESSION['uname'], $_SESSION['authcode']);

if($authUser == 'authUnSucc') {
    //destroy the current session:
    session_destroy();
    //go to the login page:
    header('Location: '.BACKEND_LINK_ROOT);
} else {}
//determine what rights this user has on this page:
$currentPage = 'articleDetail';
$rights = $checkUser->checkRights($_SESSION['authcode'], $_SESSION['uname'], $currentPage);
if($rights == 'VIEW_EDIT_FALSE') {
    if($_SESSION["lastpage"] == '') { $_SESSION["lastpage"] = 'overview'; }
    header('Location:'.$_SESSION["lastpage"]);
}
//set the last visited page, so the application can refer a user to that page when needed:
$_SESSION["lastpage"] = $currentPage;

//set the last page, hardcoded:
$vorigeURL = BACKEND_LINK_ROOT.'articleList';
$uname = $_SESSION['uname'];

$editFunction = 'editArticle';
//IF data has been submitted:
if(isset($_POST[editpagesubmit])) {
//fill an array with the values submitted by the admin:
    foreach($_POST as $value) {
        $formValues[0] = $_POST;
    }
//send the array containing the values to the model:
    $editedInfo = new BaseModel;
    $editSuccess = $editedInfo->editItem($editFunction, $formValues, $uname);
}

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
    //determine the ID of the article that has been requested:
    $idArray = explode('/',$_SERVER['REQUEST_URI']); 
    array_shift($idArray); 
    $id = $idArray[2];
    //determine that to collect the data for this page we need the function
    //'getArticleDetails':
    $getFunction = 'getArticleDetails';
    //collect the data by using the above stated function and the requested ID:
    $itemDetails = new BaseModel;
    $itemDetails1 = $itemDetails->showItem($getFunction,$id);
?>
        <?php if(isset($editSuccess)) { ?>
        <div id="contentcontainer">
            <div id="contenteditsucces">
                Het <?php echo '<a href="'.BACKEND_LINK_ROOT.'articleDetail/'.$id.'">artikel</a>'; ?> is aangepast, 
                <?php echo '<a href="'.$vorigeURL.'">klik hier</a>'; ?>
                om terug te keren naar de overzichtspagina
                <br/>
                
                of wacht 5 seconden voor een automatische redirect naar de overzichtspagina
            </div>
        </div>
        <?php
        }else { ?>
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
                            <input type="text" name="artID" class="editcontentitemcontentgrey" readonly="readonly" value="<?php echo $itemDetails1[0]["artID"]; ?>" />
                        </div>
                        <div class="editcontentitem">
                            <div class="editcontentitemtitle">Article Title:</div>
                            <?php
                                if($rights == 'EDIT_TRUE') {
                                    ?><input type="text" name="title" class="editcontentitemcontent"  value="<?php echo $itemDetails1[0]["title"]; ?>" /><?php
                                }
                                else {
                                    ?><input type="text" name="title" class="editcontentitemcontentgrey" readonly="readonly" value="<?php echo $itemDetails1[0]["title"]; ?>" /><?php
                                }
                            ?>
                        </div>
                        <div class="editcontentitem">
                            <div class="editcontentitemlongleft">
                                <div class="editcontentitemtitle">Article Body:</div>
                            </div>
                            <div class="editcontentitemlongright">
                            <?php
                                if($rights == 'EDIT_TRUE') {
                                    ?><textarea cols="1" rows="1" name="body" class="editcontentitemcontentlong"><?php echo $itemDetails1[0]["body"]; ?></textarea><?php
                                }
                                else {
                                    ?><textarea cols="1" rows="1" name="body" readonly="readonly" class="editcontentitemcontentlonggrey"><?php echo $itemDetails1[0]["body"]; ?></textarea><?php
                                } 
                            ?>
                            </div>
                        </div>
                        <div class="editcontentitem">
                            <div class="editcontentitemtitle">Article Author:</div>
                            <input type="text" name="author" class="editcontentitemcontentgrey" readonly="readonly" value="<?php echo $itemDetails1[0]["author"]; ?>" />
                        </div>
                        <div class="editcontentitem">
                            <div class="editcontentitemtitle">Creation Date:</div>
                            <input type="text" name="creationDate" class="editcontentitemcontentgrey" readonly="readonly" value="<?php echo $itemDetails1[0]["creationDate"]; ?>" />
                        </div>
                        <div class="editcontentitem">
                            <div class="editcontentitemtitle">Modified By:</div>
                            <input type="text" name="modifiedBy" class="editcontentitemcontentgrey" readonly="readonly" value="<?php echo $itemDetails1[0]["modifiedBy"]; ?>" />
                        </div>
                        <div class="editcontentitem">
                            <div class="editcontentitemtitle">Modify Date:</div>
                            <input type="text" name="modifyDate" class="editcontentitemcontentgrey" readonly="readonly" value="<?php echo $itemDetails1[0]["modifyDate"]; ?>" />
                        </div>
<?php
    $getFunction = 'getArticleCategories';
    $itemDetails = new BaseModel;
    $itemDetails2 = $itemDetails->showItems($getFunction);
?>
                        <?php if($rights == 'EDIT_TRUE') { ?>
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
                            <?php } else { ?>
                                <div class="editcontentitem">
                                    <div class="editcontentitemtitle">Category:</div>
                                    <input type="text" name="modifyDate" class="editcontentitemcontentgrey" readonly="readonly" value="<?php echo $itemDetails1[0]["categoryName"]; ?>" />
                                </div>
                            <?php } ?>
<?php
    $getFunction = 'getArticlePages';
    $itemDetails = new BaseModel;
    $itemDetails3 = $itemDetails->showItems($getFunction);
?>  
                        <?php if($rights == 'EDIT_TRUE') { ?>    
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
                            <?php } else { ?>
                                <div class="editcontentitem">
                                    <div class="editcontentitemtitle">Page:</div>
                                    <input type="text" name="modifyDate" class="editcontentitemcontentgrey" readonly="readonly" value="<?php echo $itemDetails1[0]["pageName"]; ?>" />
                                </div>
                            <?php } ?>
                       <?php echo '<a href="'.$vorigeURL.'" class="editpagecancel">ANNULEREN</a>'; ?>
                       
                       <input style="cursor: pointer;" type="submit" name="editpagesubmit" value="OPSLAAN" class="editpagesubmit"/>
                    </form>
                    </div>
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
<?php } ?>