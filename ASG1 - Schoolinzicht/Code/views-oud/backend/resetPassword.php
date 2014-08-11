<?php 

//Designed and written in the year 2012, for ASG, by:
//Peter van Kleef, Richard Floris & Pepijn de Vries.

    require_once MODEL_USER; 
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="../../_include/css/backend/default.css" />
        <link rel="stylesheet" type="text/css" href="../../_include/css/backend/login.css" />
        <title>SCHOOLINZICHT - Backend - Reset Password</title>
    </head>
    <body class="body">
        <?php 
            $url = $_SERVER['REQUEST_URI'];
            $idArray = explode('/',$_SERVER['REQUEST_URI']); 
            array_shift($idArray); 
            $id = $idArray[2];

            $pieces = explode("&", $id);
            $uname = $pieces[0];
            $email = $pieces[1];
            session_start();

            $checkResets = new User;
            $checkUserReset = $checkResets->checkUsers();

            $i = 0;

            foreach($checkUserReset as $value) {    
              
               if(  ($uname == md5($checkUserReset[$i]['name'])) && ($email == md5($checkUserReset[$i]['emailAddress'])) && ($checkUserReset[$i]['verifyCode'] != '')) {
                       if(isset($_POST['submitStep1'])) {
                            $_SESSION['veriCode'] = $_POST['veriCode'];
                            $checkVeriCode = new User;
                            $checkVeri = $checkVeriCode->checkVeriCode($uname, $email, $_POST['veriCode']);       
                           if($checkVeri != 'veriSucc') {
                                ?>
                                    <div id="contentcontainer">
                                        <div id="contenteditsucces">
                                            De door u ingevoerde verificatiecode is niet juist, probeer het nogmaals.
                                            <br/>
                                            u wordt binnen  5 seconden automatisch teruggestuurd naar de verificatiepagina.
                                            <?php header('refresh: 5; url=' .$url); ?>
                                        </div>
                                    </div>
                                <?php
                           }
                           else {
                            ?>
                                <div id="contentcontainer">
                                    <div id="logincontainer">
                                        <?php echo '<form action="" method="POST">'; ?>
                                            <div id="logincontentleft1">
                                                <div class="logintitle">RESET PASSWORD</div>
                                                <div class="loginitem">
                                                    <div class="loginitemtitle1">Nieuw Wachtwoord:</div>
                                                    <input type="password" name="wachtwoord1" class="loginitemcontent" />
                                                </div>
                                                <div class="loginitem">
                                                    <div class="loginitemtitle1">Herhaal wachtwoord:</div>
                                                    <input type="password" name="wachtwoord2" class="loginitemcontent" />
                                                </div>
                                                <input style="cursor: pointer;" type="submit" name="submitStep2" value="LOG IN" class="loginsubmit" />
                                            </div>
                                        <?php echo '</form>'; ?>
                                    </div>
                                    ..
                                </div>
                            <?php 
                           }
                       }
                       elseif(isset($_POST['submitStep2'])) {
                           if($_POST['wachtwoord1'] != $_POST['wachtwoord2']) {
                                ?>
                                    <div id="contentcontainer">
                                        <div id="contenteditsucces">
                                            De door u ingevoerde wachtwoorden verschillen van elkaar, probeer het nogmaals.
                                        </div>
                                        <div id="logincontainer">
                                            <?php echo '<form action="" method="POST">'; ?>
                                                <div id="logincontentleft1">
                                                    <div class="logintitle">RESET PASSWORD</div>
                                                    <div class="loginitem">
                                                        <div class="loginitemtitle1">Nieuw Wachtwoord:</div>
                                                        <input type="password" name="wachtwoord1" class="loginitemcontent" />
                                                    </div>
                                                    <div class="loginitem">
                                                        <div class="loginitemtitle1">Herhaal wachtwoord:</div>
                                                        <input type="password" name="wachtwoord2" class="loginitemcontent" />
                                                    </div>
                                                    <input style="cursor: pointer;" type="submit" name="submitStep2" value="OPSLAAN" class="loginsubmit" />
                                                </div>
                                            <?php echo '</form>'; ?>
                                        </div>
                                    </div>
                                <?php
                           }
                           else {
                            $wachtwoord = $_POST['wachtwoord1'];
                            $updatePass = new User;
                            $changePass = $updatePass->resetPassword($uname, $email, $wachtwoord, 'resetPass', $_SESSION['veriCode']);      
                                if($changePass == 'resetSucc') {
                                    ?>
                                        <div id="contentcontainer">
                                            <div id="contenteditsucces">
                                                Uw wachtwoord is succesvol gewijzigd,
                                                <br/>
                                                u wordt binnen  5 seconden automatische doorgestuurd naar de loginpagina.
                                                <?php header('refresh: 5; url='.BACKEND_LINK_ROOT); ?>
                                            </div>
                                        </div>
                                    <?php
                                }
                                else {
                                   ?>
                                        <div id="contentcontainer">
                                            <div id="contenteditsucces">
                                                Er is een fout opgetreden, probeert u het nogmaals.
                                                <br/>
                                                U wordt binnen  5 seconden automatische doorgestuurd naar de beginpagina.
                                                <?php header('refresh: 5; url=' .$url); ?>
                                            </div>
                                        </div>
                                    <?php
                                }
                           }
                       }
                       else {
                ?>
                    <div id="contentcontainer">

                        <div id="logincontainer">

                            <?php echo '<form action="" method="POST">'; ?>
                                <div id="logincontentleft1">
                                    <div class="logintitle">RESET PASSWORD</div>
                                    <div class="loginitem">
                                        <div class="loginitemtitle">Verificatiecode:</div>
                                        <input type="text" name="veriCode" class="loginitemcontent" />
                                    </div>
                                    <input style="cursor: pointer;" type="submit" name="submitStep1" value="VERIFIËREN" class="loginsubmit" />
                                </div>
                            <?php echo '</form>'; ?>
                        </div>
                        ..
                    </div>
                <?php
                       } } elseif(($uname == md5($checkUserReset[$i]['name'])) && ($email == md5($checkUserReset[$i]['emailAddress'])) && ($checkUserReset[$i]['verifyCode'] == '')) {
                ?>
                    <div id="contentcontainer">
                        <div id="contenteditsucces">
                            U heeft geen wachtwoord reset aangevraagd, deze pagina is daardoor niet geldig.
                            <br/>
                            u wordt binnen  5 seconden automatische doorgestuurd naar de loginpagina.
                            <?php $this->setRedirect(login); ?>
                        </div>
                    </div>
                <?php
               }
               $i++;
            }
        ?>
    </body>
</html>