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
$currentPage = 'schoolDetail';
$rights = $checkUser->checkRights($_SESSION['authcode'], $_SESSION['uname'], $currentPage);
if($rights == 'VIEW_EDIT_FALSE') {
    if($_SESSION["lastpage"] == '') { $_SESSION["lastpage"] = 'overview'; }
    header('Location:'.$_SESSION["lastpage"]);
}
$_SESSION["lastpage"] = $currentPage;

$vorigeURL = BACKEND_LINK_ROOT.'schoolList';
$uname = $_SESSION['uname'];

$editFunction = 'editArticle';
if(isset($_POST[editpagesubmit])) {
    foreach($_POST as $value) {
        $formValues[0] = $_POST;
    }
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
    $idArray = explode('/',$_SERVER['REQUEST_URI']); 
    array_shift($idArray); 
    $id = $idArray[2];
    $getFunction = 'getSchool';
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
                <?php $huppeldepup = 'test'; ?>
            </div>
        </div>
        <?php } elseif($huppeldepup == 'test') {
            $time=5; sleep($time); header('Location: '.BACKEND_LINK_ROOT.'articleList');   
        }else { ?>
        <div id="contentcontainer">
            <div id="editcontentcontainer">
                <div id="editcontentleftrightcontainer">
                    <div id="editcontentleftcontainer">
                        <form action="" method="POST">
                            <div class="editcontentitem">
                                <div class="editcontentitemtitle"><u>LET OP!</u></div>
                                <input type="text" name="ArticleAuthor" class="editcontentitemcontentred" readonly="readonly" value="DIT ARTIKEL KAN NIET WORDEN AANGEPAST" />
                            </div>
                        <div class="editcontentitem">
                            <div class="editcontentitemtitle">BRIN:</div>
                            <input type="text" name="BRIN" class="editcontentitemcontentgrey" readonly="readonly" value="<?php echo $itemDetails1[0]["BRIN"]; ?>" />
                        </div>
                        <div class="editcontentitem">
                            <div class="editcontentitemtitle">Schoolnaam:</div>
                            <input type="text" name="BRIN" class="editcontentitemcontentgrey" readonly="readonly" value="<?php echo $itemDetails1[0]["schoolName"]; ?>" />
                        </div>
                        <div class="editcontentitem">
                            <div class="editcontentitemtitle">Educatie Type:</div>
                            <input type="text" name="BRIN" class="editcontentitemcontentgrey" readonly="readonly" value="<?php echo $itemDetails1[0]["educationType"]; ?>" />
                        </div>
                        <div class="editcontentitem">
                            <div class="editcontentitemtitle">School Type:</div>
                            <input type="text" name="BRIN" class="editcontentitemcontentgrey" readonly="readonly" value="<?php echo $itemDetails1[0]["schoolType"]; ?>" />
                        </div>
                        <div class="editcontentitem">
                            <div class="editcontentitemtitle">Website:</div>
                            <input type="text" name="BRIN" class="editcontentitemcontentgrey" readonly="readonly" value="<?php echo $itemDetails1[0]["website"]; ?>" />
                        </div>
                        <div class="editcontentitem">
                            <div class="editcontentitemtitle">Adres:</div>
                            <input type="text" name="BRIN" class="editcontentitemcontentgrey" readonly="readonly" value="<?php echo $itemDetails1[0]["address"]; ?>" />
                        </div>
                        <div class="editcontentitem">
                            <div class="editcontentitemtitle">Postcode:</div>
                            <input type="text" name="BRIN" class="editcontentitemcontentgrey" readonly="readonly" value="<?php echo $itemDetails1[0]["postalCode"]; ?>" />
                        </div>
                        <div class="editcontentitem">
                            <div class="editcontentitemtitle">BRIN:</div>
                            <input type="text" name="BRIN" class="editcontentitemcontentgrey" readonly="readonly" value="<?php echo $itemDetails1[0]["BRIN"]; ?>" />
                        </div>
                        <div class="editcontentitem">
                            <div class="editcontentitemtitle">Logo:</div>
                            <input type="text" name="BRIN" class="editcontentitemcontentgrey" readonly="readonly" value="<?php echo $itemDetails1[0]["logoPath"]; ?>" />
                        </div>
                        <div class="editcontentitem">
                            <div class="editcontentitemtitle">Kinderopvang:</div>
                            <input type="text" name="BRIN" class="editcontentitemcontentgrey" readonly="readonly" value="<?php echo $itemDetails1[0]["childCare"]; ?>" />
                        </div>
                        <div class="editcontentitem">
                            <div class="editcontentitemtitle">Schoolbestuur:</div>
                            <input type="text" name="BRIN" class="editcontentitemcontentgrey" readonly="readonly" value="<?php echo $itemDetails1[0]["boardName"]; ?>" />
                        </div>
                        <div class="editcontentitem">
                            <div class="editcontentitemtitle">E-mailadres:</div>
                            <input type="text" name="BRIN" class="editcontentitemcontentgrey" readonly="readonly" value="<?php echo $itemDetails1[0]["emailadress"]; ?>" />
                        </div>
                        <div class="editcontentitem">
                            <div class="editcontentitemtitle">Loc. Latitude:</div>
                            <input type="text" name="BRIN" class="editcontentitemcontentgrey" readonly="readonly" value="<?php echo $itemDetails1[0]["schoolLat"]; ?>" />
                        </div>
                        <div class="editcontentitem">
                            <div class="editcontentitemtitle">Loc. Lengitude:</div>
                            <input type="text" name="BRIN" class="editcontentitemcontentgrey" readonly="readonly" value="<?php echo $itemDetails1[0]["schoolLong"]; ?>" />
                        </div>
                            <?php echo '<a href="'.$vorigeURL.'" class="editpagecancel">ANNULEREN</a>'; ?>
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