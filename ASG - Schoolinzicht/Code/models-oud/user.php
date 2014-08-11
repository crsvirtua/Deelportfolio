<?php

//Designed and written in the year 2012, for ASG, by:
//Peter van Kleef, Richard Floris & Pepijn de Vries.

require_once MODEL_BASEMODEL;
require_once INCLUDE_QUERYMANAGER;

class User extends BaseModel{

    
   
    
    //function to determine if a user can login or not
    function login($uname, $pwd) {
        
        //get username and password fromdatbase where username = username:
        $contentthroughput = new queryManager;
        $content = $contentthroughput->validateUser($uname);
        
        //if user submitted username and password equal the data from the database:
        if(($content[0]["name"] == $uname) && ($content[0]["password"] == $pwd)) {
            
            //generate the authenticationcode:
            $length = 40;
            $genAuthCode = new BaseModel();
            $authcode = $genAuthCode->generateRandString($length);

            //upload the authenticationcode:
            $authCodeUpload = new queryManager;
            $authCodeUpload->updateAuthCode($authcode, $uname);
            
            //return a loginSucces message, the authenticationcode and the username:
            $returnValue[0] = "loginSucc";
            $returnValue[1] = $authcode;
            $returnValue[2] = $uname;

            return $returnValue;
        }
        //if the submitted data doesn't correspond with the database data:
        else {
            //return a loginUnsuccesful message, an empty authenticationcode, no username and an errormessage:
            $returnValue[0] = "loginUnSucc";
            $returnValue[1] = "0";
            $returnValue[2] = "unknown";
            $returnValue[3] = "Your login request was unsuccessful, please try again!";
            
            return $returnValue;
        }
    }
    
    //function to authenticate a user
    function authenticateUser($uname, $authcode) {
        //set the username to 'none' when it doesnt exist:
        if($uname == '') { $uname = 'none'; }
        //make the whole username lowercase:
        $username = strtolower($uname);
        //check if the user exists and get an authcode from the database:
        $dbAuthCode = new queryManager;
        $check = $dbAuthCode->checkAuthCode($username);
        
        //if the user authentication code is NOT the same as the one from the database:
        if($check[0]['authcode'] != $authcode ) {
            
            //destroy the authenticationcode in the database:
            $destroyDBAuthCode = new queryManager;
            $destroyDBAuthCode->destroyAuthCode($uname);
            
            return 'authUnSucc';
        }
        elseif($username == 'none') {
            return 'authUnSucc';
        }
        else { return 'authSucc'; }
    }
    
    //function to logout:
    function logout($uname) {
        $destroyDBAuthCode = new queryManager;
        $destroyDBAuthCode->destroyAuthCode($uname);

        return 'logoutSucc';
    }
    
    //function to reset a user's password
    function resetPassword($uname, $email, $newPassword, $state, $veriCode) {
        
        //if there is no state, set the state to new:
        if(empty($state)) { $state = 'new'; }
        
        //check if the submitted email and username are the same as the ones in the database:
        $authFormVal = new queryManager;
        $check = $authFormVal->checkPassReset($uname, $email);
        
        //if the password should be reset:
        if($state == 'resetPass') {
            //upload new password:
            $newPasswordUpload = new queryManager;
            $newPasswordUpload->updatePassword($veriCode, $newPassword);       
            
            return 'resetSucc';
            
        }
        //if there was no result from the check:
        elseif(empty($check)) {
            
            return 'ditwerktdusniet';
            
        }
        //if the state was not 'new' and also not 'resetPass:
        elseif(($state != 'new') && ($state != 'resetPass')) {
            return 'resetUnSucc';
        }
        //else the password reset request was successfull:
        else {
            //send an email with a random code:
            //generate the random code:
            $length = '10';
            $genPassword = new BaseModel();
            $verificationCode = $genPassword->generateRandString($length);
            
            //send an email:
            $to         = $email;
            $subject    = 'SCHOOLINZICHT - Reset password request';
            $message    = '<html><p>
                          Hi,
                          </p> 
                          We have received the request to reset your password. 
                          <br/> 
                          If it was indeed you that has requested this reset, 
                          <br/> 
                          please click <a href="'.BACKEND_LINK_ROOT.'resetPassword/'.md5($uname).'&'.md5($email).'"><b>THIS LINK</b></a> 
                          <br/>
                          Use the following unique code to identify yourself at the website stated above.
                          <br/>
                          Your Code: &nbsp;&nbsp;&nbsp;&nbsp;<b>'.$verificationCode.'</b>
                          <br/> <br/> <br/>
                          If it was not your own request: please ignore this e-mail.
                          <br/><br/><br/>
                          Regards, the SCHOOLINZICHT team.</html>';
            $headers    = 'From: SCHOOLINZICHT <noreply@schoolinzicht.nl>' . "\r\n";
            $headers   .= 'MIME-Version: 1.0' . "\r\n";
            $headers   .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            
            mail($to, $subject, $message, $headers);
            
            //upload the random code (verificationcode) to the database:
            $newVeriCode = new queryManager;
            $veriCodeUpload = $newVeriCode->uploadVeriCode($uname, $email, $verificationCode); 
            
            return 'resetSucc';
            
        } 
    }
    //function to check if user submitted verificationcode is equal to the one in the database:
    function checkVeriCode($uname, $email, $veriCode) {
        
        //see if the verificationcode exists:
        $authFormVal = new queryManager;
        $check = $authFormVal->checkVeriCode($veriCode);
        
        //if there were no results:
        if(empty($check)) {
            
            return 'veriUnSucc';
            
        }
        
        //if there were results:
        else { 
            //if the username is the same as the one in the url and the email is the same as the one in the url:
            if((md5($check[0]["name"]) == $uname) && (md5($check[0]["emailAddress"]) == $email) ) {

                return 'veriSucc'; 
            }
            //else:
            else { return 'veriUnSucc'; }
        }
    }
    function checkUsers() {
        
        $checkUsers = new queryManager;
        $users = $checkUsers->checkAllUsers();
        
        return $users;
    }
    
    //function to determine which rights a specific user has on a specific page:
    function checkRights($authCode, $username, $currentPage) {
        
        $queryManager = new queryManager;
        
        //get the accesslevel for this user from the database:
        $userLevel = $queryManager->grabUserLevel($authCode, $username);
        //get the rights that come with this accesslevel:
        $pageRights = $queryManager->grabUserRights($userLevel[0]["accessLevel"]);
        
        //put all the view AND edit rights in different arrays:
        $editIDRightsArray = explode(",", $pageRights[0]['edit']);
        $viewIDRightsArray = explode(",", $pageRights[0]['viewOnly']);
        
        $i=0;
        $u=0;
        //for each EDIT value in the edit array:
        foreach($editIDRightsArray as $value) {
            //set the pageName in an array, instead od the pageID:
            $editRightsArray[$i] = $queryManager->getPageName($value);
            $i++;
        }
        //for each VIEW value in the view array:
        foreach($viewIDRightsArray as $value) {
            //set the pageName in an array, instead od the pageID:
            $viewRightsArray[$u] = $queryManager->getPageName($value);
            $u++;
        }
        //for each EDIT value in the edit array:
        foreach($editRightsArray as $value) {
            //see if the value corresponds to the current page the user is on:
            if($value[0]['pageName'] == $currentPage) {
                //if so: return that the user has edit rights:
                return 'EDIT_TRUE';
            }
            else {}
        }
        //for each VIEW value in the view array:
        foreach($viewRightsArray as $value) {
            //see if the value corresponds to the current page the user is on:
            if($value[0]['pageName'] == $currentPage) {
                //if so: return that the user has view rights:
                return 'VIEW_TRUE';
            }
            else {}
        }
        //else: return that the user has no VIEW and no EDIT rights:
        return 'VIEW_EDIT_FALSE';
        
    }
    function getUserDetail($userID) {
        $userData = new queryManager;
        $userInfo = $userData->getUserDetails($userID);
        return $userInfo;
    }
}

?>