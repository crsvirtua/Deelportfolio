<?php

//Designed and written in the year 2012, for ASG, by:
//Peter van Kleef, Richard Floris & Pepijn de Vries.

session_start();
require_once MODEL_USER;

$logoutReq = new User;
$logout = $logoutReq->logout($_SESSION['uname']);

if($logout == 'logoutSucc') {
    session_destroy();
    header('Location: '.BACKEND_LINK_ROOT);
}
?>
