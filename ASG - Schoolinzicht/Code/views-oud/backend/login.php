<?php

//Designed and written in the year 2012, for ASG, by:
//Peter van Kleef, Richard Floris & Pepijn de Vries.

session_start();
require_once MODEL_USER;

$urlParameters = explode('/',$_SERVER['REQUEST_URI']); 
array_shift($urlParameters); 
$urlParameter = $urlParameters[2];
    
if(isset($_POST['username']) && isset($_POST['password'])) {
    $uname = $_POST['username'];
    $pwd = $_POST['password'];
    $login = new User;
    $logging = $login->login($uname, $pwd);
    
    if($logging[0] == "loginSucc") {
        $_SESSION ['uname'] = ucfirst($logging[2]);
        $_SESSION ['authcode'] = $logging[1];
        if($urlParameter != '') {
            header('Location: '.BACKEND_LINK_ROOT.'schoolUpdate/'.$urlParameter);
        }
        else {
            header('Location: '.BACKEND_LINK_ROOT.'articleList');
        }
    } elseif($logging[0] == 'loginUnSucc') {
        $_SESSION ['uname'] = $logging[2];
        $_SESSION ['authcode'] = $logging[1];
        session_destroy();
    }
  
}
elseif(isset($_POST['usernameForgot']) && isset($_POST['emailaddressForgot'])) {
    $uname = $_POST['usernameForgot'];
    $email = $_POST['emailaddressForgot'];
    
    $forgotPass = new User;
    $resetPassword = $forgotPass->resetPassword($uname, $email);
    
    if($resetPassword == 'resetSucc') {
        
        $displayMessage =  "The data you have filled in corresponds with the data in the Database. <br/> an e-mail has been sent.";
        
    }
    elseif($resetPassword == 'resetUnSucc') {
        
        $displayMessage = "The data you have filled in does not correspond with the data in the Database, please try again.";
        
    }
}


?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="../../_include/css/backend/default.css" />
        <link rel="stylesheet" type="text/css" href="../../_include/css/backend/login.css" />
        <?php if(isset($displayMessage)) { echo '<meta http-equiv="refresh" content="5; URL='.BACKEND_LINK_ROOT.'login">'; } else { } ?>
        <title>SCHOOLINZICHT - Backend</title>
    </head>
    <body class="body">
        <?php if(isset($displayMessage)) { ?>
        <div id="contentcontainer">
            <div id="contenteditsucces">
               <?php echo $displayMessage; ?>
                
                <br/> Click <a href="">HERE</a> to return, or wait 5 seconds for this page to automatically refresh.
            </div>
        </div>
        <?php } else { ?>
        <div id="contentcontainer">

            <div id="logincontainer">
                            
                <?php echo '<form action="" method="POST">'; ?>
                    <div id="logincontentleft">
                        <div class="logintitle">INLOGGEN</div>
                        <div class="loginitem">
                            <div class="loginitemtitle">USERNAME:</div>
                            <input type="text" name="username" class="loginitemcontent" />
                        </div>
                        <div class="loginitem">
                            <div class="loginitemtitle">PASSWORD:</div>
                            <input type="password" name="password" class="loginitemcontent" />
                        </div>
                        <input style="cursor: pointer;" type="submit" name="loginsubmit" value="LOG IN" class="loginsubmit" />
                        <?php if($logging != '') { ?>
                            <div class="loginitem">
                                <?php echo "<br/><br/>".$logging[3]; ?>
                            </div>
                        <?php } ?>
                    </div>
                <?php echo '</form>'; ?>
                
                <?php echo '<form action="'.BACKEND_LINK_ROOT.'login" method="POST">'; ?>
                    <div id="logincontentright">
                        <div class="logintitle">WACHTWOORD VERGETEN</div>
                        <div class="loginitem">
                            <div class="loginitemtitle">USERNAME:</div>
                            <input type="text" name="usernameForgot" class="loginitemcontent" />
                        </div>
                        <div class="loginitem">
                            <div class="loginitemtitle">E-MAILADRES:</div>
                            <input type="email" name="emailaddressForgot" class="loginitemcontent" />
                        </div>
                        <input style="cursor: pointer;" type="submit" name="loginsubmit" value="VERSTUREN" class="loginsubmit"/>
                    </div>
                <?php echo '</form>'; ?>

            </div>
                            
            ..
        </div>
        <?php } ?>
    </body>
</html>