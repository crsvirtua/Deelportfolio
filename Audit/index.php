<?php 
ini_set('session.gc_maxlifetime', 28800);
session_set_cookie_params(28800);
    session_start();
    
    require_once("_include/queryManager.php"); 
    $query = new querymanager;

    if($_SESSION['notloggedin']=='loggedout'){
        //set error when user has logged out:
        $error = "Log nogmaals in";
    }
    elseif($_SESSION['loggedin']=='logged' && $_SESSION['permission']=='admin'){
        //if a user is already logged in redirect him to the startAudit page:
        header("Location: startAudit.php");
    }
    elseif($_SESSION['loggedin']=='logged' && $_SESSION['permission']=='client'){
        //if a user is already logged in redirect him to the startAudit page:
        header("Location: startAudit.php");
    }
    else {}

    if(isset($_POST)){
        //retreive the key from the database:
        $key = $query->validateKey();
        //see if the loginkey from the database references the user's key:
        if($_POST["loginkey"] == $key[0]["loginKey"]){
            //set error to nothing (when the keys match):
            $error="";
            //set state to login:
            $_SESSION['loggedin']='logged'; 
            //set state to client:
            $_SESSION['permission'] = 'admin';
            //send user to startAudit page:
            header("Location: startAudit.php");
        } 
        elseif($_POST["loginkey"] == $key[1]["loginKey"]){
            //set error to nothing (when the keys match):
            $error="";
            //set state to login:
            $_SESSION['loggedin']='logged'; 
            //set state to client:
            $_SESSION['permission'] = 'client';
            //send user to startAudit page:
            header("Location: startAudit.php");
        } 
        elseif($_POST["loginkey"] != $key[0]["loginKey"] && $_POST['loginkey'] != $key[1]["loginKey"]) {
            //set error (when the keys don't match:):
            $error = "De code die u heeft ingevoerd is helaas niet correct, probeer het nogmaals.";
        }
    } 
    if(empty($_POST)) {
        //set error to nothing (if the user has not submitted anything yet):
        $error="";
    }
    //remove the user submitted key:
    unset($_POST["loginkey"]);
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="_include/css/index.css"/>
        <title>Audit App Pilot - Login</title>
    </head>
    <body id="body">
        <div id="contentcontainer">
            <div id="pageTitle">
                LOGIN
            </div>
            <div id="pageContent">
                <?php 
                //if there is an error, display it:
                    if(!empty($error)) { ?>
                    <br/>
                    <div class="pageError"><img src="_include/images/error_1.jpg" alt=""/><?php echo $error; ?></div>
                <?php } ?>
                <form action="" method="POST">
                    <div class="inputfieldHeader">
                        Voer uw logincode in:
                    </div>
                    <input type="password" class="inputfield" name="loginkey" value=""/>
                    <br/>
                    <input type="submit" class="submitFormButton" value="login" style="cursor:pointer;"/>
                </form>
            </div>
        </div>
    </body>
</html>