<?php

//Designed and written in the year 2012, for ASG, by:
//Peter van Kleef, Richard Floris & Pepijn de Vries.

require_once MODEL_BASEMODEL;
require_once INCLUDE_QUERYMANAGER;
require_once MODEL_TAB;

 Class School extends BaseModel {
   
    
    
    //function used for the school 'login' (schoolUpdate, frontend)
    function authSchool($email, $brin) {
        $contentthroughput = new queryManager;
        $content = $contentthroughput->schoolAuth($brin);

        if($content[0]["emailAddress"] == $email) {
            $returnValue = "authSucc";
            return $returnValue;
        }
        else {
            $returnValue = "authUnSucc";
            return $returnValue;
        }
    }
    
    //function used for the entire schoolupdate process
    function schoolUpdate($postArray) {
  //determine the values Brin and Email:
        $brin = $postArray['BRIN'];
        $email = $postArray['emailAddress'];
        $schoolEmail = $email;
        $adminEmail = 'e.vandenheuvel@asg-almere.nl';
        
        //remove several other array parts which are not needed
        unset($postArray['educationType']); 
        unset($postArray['boardName']);
        unset($postArray['updateSubmit']);
        
        //repeat this part of the function for each seperate array value:
        foreach($postArray as $keyName=>$keyValue) {
            
            if($keyValue == 'no' || $keyValue == 'yes') { unset($keyName); }
            if($keyName == 'comment') { unset($keyName); }
            //check if the content that has been submitted is different from 
            //what is in the table:
            if(strpos($keyName,'context') !== false) {
                $id = preg_split('#(?<=[a-z])(?=\d)#i', "$keyName");
                $tabID = $id[1];
                $functionToRun = new queryManager;
                $content = $functionToRun->checkFields2($tabID, $keyValue, $brin);
                if(!empty($content)) {
                    if($postArray[$keyName] != $content[0]['context']) {
                        $uploadInfo = new queryManager;
                        $content = $uploadInfo->uploadField($keyName, $keyValue, $brin, $email);
                    }
                    else {}
                }
                else {}
            }
            //check if a user has tried to upload an IMAGE
            if($keyName == "logoPath") {
                return ("logoPath found");
                if($image != 'alreadyDone') {
                    if(!empty($_FILES["logoPath"]["name"])) { 
                        //This function separates the extension from the rest of the file name and returns it 
                        $filename = strtolower($_FILES["logoPath"]["name"]); 
                        //split the filename into several parts (every new part starts with a .):
                        $parts = explode(".", $filename);
                        //make sure we select the last part (the extension):
                        $n = count($parts)-1; 
                        $exts = $parts[$n]; 
                        //if the extension "png" we want to upload it:
                        if($exts == 'png') {
                            $filename = $brin.".".$exts;
                            $target = LOGO_IMAGES_PATH."tmp/"; 
                            $target = $target.$filename;
                            if(!move_uploaded_file($_FILES['logoPath']['tmp_name'], $target)) {
                                return "upload failed";
                            } 
                            else {
                                return "upload successful";
                            } 
                        }
                        else {}
                        $image = 'alreadyDone';
                    }
                }
            }
            else {
                $functionToRun = new queryManager;
                $content = $functionToRun->checkFields($keyName, $keyValue, $brin);
                //if it is in fact different:
                if($postArray[$keyName] != $content[0][$keyName]) {
                    //upload the data:
                    $uploadInfo = new queryManager;
                    $content = $uploadInfo->uploadField($keyName, $keyValue, $brin, $email);
                }
            }
        }
        
        //send a confirmation email to both the school and the admin:
        $email      = $adminEmail; //the admin e-mail address !!
        
        $to         = $adminEmail;
        $subject    = 'Schoolinzicht, schoolupdate';
        $message    = '<html><p>
                        Hi,
                        </p>
                        One of the schools has edited its information and is
                        awaiting your approval. 
                        <br/>
                        Please click the following link to view the edited information:
                        <br/>
                        <a href="'.BACKEND_LINK_ROOT.'login/'.$brin.'">
                        <b>VIEW THE EDITED INFORMATION</b></a>
                        <br/>
                        Regards, The SCHOOLINZICHT team.
                    </html>';
        $headers    = 'From: SCHOOLINZICHT <noreply@schoolinzicht.nl>' . "\r\n";
        $headers   .= 'MIME-Version: 1.0' . "\r\n";
        $headers   .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        mail($to, $subject, $message, $headers);
        
        $email      = $schoolEmail; //the school e-mail address!!
        
        $to         = $schoolEmail;
        $subject    = 'Schoolinzicht, schoolupdate';
        $message    = '<html><p>
                        Hi,
                        </p>
                        We have received your information change request. <br/>
                        
                        An admin will look at your request and either approve or deny it.<br/><br/>
                        You will receive another e-mail when an admin has looked at the information<br/>
                        you have supplied him with.
                        <br/>
                        Regards, The SCHOOLINZICHT team.
                    </html>';
        $headers    = 'From: SCHOOLINZICHT <noreply@schoolinzicht.nl>' . "\r\n";
        $headers   .= 'MIME-Version: 1.0' . "\r\n";
        $headers   .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        mail($to, $subject, $message, $headers);

        return 'uploadSucc';
    }
    
    //function used to load all available temporary data for the schoolUpdate page:
    function loadTemp($brin) {
        $functionToRun = new queryManager;
        $content = $functionToRun->downloadTemp($brin);
        
        return $content; 
    }
    
    //upload data to either temporary ot stationary database after admincheck:
    function uploadData($postArray) {
        $BRIN = $postArray["BRIN"];
        
        $functionToRun = new queryManager;
        $schoolEmailAddress = $functionToRun->downloadSchoolEmail($BRIN);
        
        $email = $schoolEmailAddress;
        //remove everything of that brin from the TEMP table:
        $uploadData = new queryManager;
        $deleteData = $uploadData->deleteTempData($BRIN);
        $length = $postArray['LENGTH'];
        unset($postArray['LENGTH']);
        //remove the 'submit' from the postarray:
        unset($postArray['approveSubmit']);
        //give each postarray value a unique ID:
        $i = 0;
        echo $length;
        for($p=0;$p<$length;$p++) {
            $ID[$p] = $postArray["ID&$p"];
        }            
        //for each unique ID:
        foreach($ID as $i) {
            //set the different values we need:
            $type = trim(str_replace(range(0,9),'',$postArray["type&".$i])); //context6 -> context
            $UPLOADID = $postArray["type&".$i];
            $content = $postArray["content&".$i];
            $comment = $postArray["comment&".$i];
            $arrayApprove = trim(str_replace(range(0,9),'',$postArray["approve&".$i])); 
            //if this item was a 'approved':
            echo $type."<br/>".$content."<br/>".$comment."<br/>".$arrayApprove;
            if($arrayApprove == 'approved') {
                //upload the approved fields to the stationary table:
                $uploadData = new queryManager;
                if(strpos($type,'context') !== false) {
                    echo "dit is dus context";
                    //$id = preg_split('#(?<=[a-z])(?=\d)#i', "$type");
                    $id = preg_split('#(?<=[a-z])(?=\d)#i', "$UPLOADID");
                    $tabID = $id[1];
                    $dataToUpload = $uploadData->uploadContext($BRIN, $tabID, $content);
                }
                if(strpos($type, 'logoPath') !== false) {
                    $path = INCLUDES_PATH.'schoolLogos/tmp/';
                    $filename = $BRIN.'.png'; 
                    $FILE = $path.$filename;
                    $DEST = LOGO_IMAGES_PATH3.$filename;
                    copy($FILE, $DEST);
                    $dataToUpload = $uploadData->uploadLogoPath($BRIN);
                }
                elseif($type != 'context' && $type != 'logoPath') {
                    echo "dit zou niet moeten gebeuren";
                    $dataToUpload = $uploadData->changeApproved($type, $content, $BRIN);
                }
            }
            //if this item was NOT approved:
            elseif($postArray["approve&".$i] == 'notApproved' && $postArray["comment&".$i] != '') {
                //upload the data (including comment) to the temporary table:
                $uploadData = new queryManager;
                $dataToUpload = $uploadData->commentDisapproved($BRIN, $email, $type, $content, $comment);
                
                
                    //send an email containing the dissaproved field:
                    $email      = $schoolEmailAddress;

                    $to         = $email;
                    $subject    = 'Schoolinzicht, schoolupdate';
                    $message    = '<html><p>
                                    Hi,
                                    </p>
                                    You have edited some information about your school, an admin has looked at it<br/>
                                    and has not approved the following changes:
                                    
                                    '.$type.'&nbsp;&nbsp;&nbsp;'.$content.'<br/>
                                    for the following reason:<br/>
                                    '.$comment.'.
                                    Please re-edit this information, so it can be approved.<br/><br/>
                                    The information can be edited here:<br/>
                                    <a href="'.FRONTEND_LINK_ROOT.'schoolUpdate">Update your school</a>
                                    <br/>
                                    <br/>
                                    Regards, The SCHOOLINZICHT team.
                                </html>';
                    $headers    = 'From: SCHOOLINZICHT <noreply@schoolinzicht.nl>' . "\r\n";
                    $headers   .= 'MIME-Version: 1.0' . "\r\n";
                    $headers   .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

                    mail($to, $subject, $message, $headers);
                
            }
            elseif($postArray["approve&".$i] == 'notApproved' && $postArray["comment&".$i] == '') {
                $_SESSION['error'] = "One or more fields have not been uploaded, you forgot to comment.";
            }

            $i++;
            
        }
    }
}
?>