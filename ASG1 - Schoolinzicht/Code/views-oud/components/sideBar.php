<?php
require_once MODEL_CRITERIA;
require_once MODEL_MENU;
$test = new criteria;

$content = $test->getTestCriteria();  
//Sorts the array to display correctly from low to high on the screen.
sort($content, SORT_REGULAR);

//Split the first section of the URL from the criteria
$sideIdArray = explode('/', $_SERVER['REQUEST_URI']); 
//Define the current View
$view = $sideIdArray[1];

//Split all the criteriavalues
$sideIdArrayX = explode('&', $sideIdArray[2]);

if(!empty($sideIdArrayX[0])){
    $sidePostalCode = $sideIdArrayX[0];       
}

$urlArray = explode('/',$_SERVER['REQUEST_URI']);
$urlParts = explode('=', $urlArray[2]);
//split the criteria:
$criteriaArray = explode('&', $urlParts[1]);
//define postcode and distance from this split:
$postcodeAfstand = explode('&', $urlParts[0]);
$postalCode = $postcodeAfstand[0];
$distance = $postcodeAfstand[1];  
    ?>
<script> 
        //document.write(transition)
        var afstand = 0;
        var counter=0;
        //var postalcode= '1323GX';
        //For redirections and links to make sure it only goes from the root.
        var root = location.protocol + '//' + location.host;

        // disable the ENTER key, a user can't submit the form by
        // presseing enter:
        function stopRKey(evt) {
            var evt = (evt) ? evt : ((event) ? event : null);
            var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
            if ((evt.keyCode == 13) && (node.type=="text"))  {return false;}
        }
        function formChange(contentChanged) {
            //check if the URL already contains some criteria:
            //if it already contains criteria:
            var myString = window.location.href;
            var criteriaArray = myString.split('=');
            if(criteriaArray[1].indexOf('&') != -1) {
                //check if the changed criterium is already in the URL:
                //if it contains the criterium:
                if(window.location.href.indexOf(contentChanged) != -1) {
                    newCriteria = criteriaArray[1].replace("&"+contentChanged,"");
                    criteriaArray[1] = newCriteria.replace(/'/g,"");
                    newURL = criteriaArray.join('=');
                    window.location = newURL;
                } 
                //if it doesn't contain this criterium:
                else {
                    criteriaArray[1] = criteriaArray[1]+'&'+contentChanged;
                    newURL = criteriaArray.join('=');
                    window.location = newURL;
                }
            }
            //if it doesnt contain any criteria:
            else { 
                criteriaArray[1] = criteriaArray[1]+'&'+contentChanged;
                newURL = criteriaArray.join('=');
                window.location = newURL;
            }
        }
        function formChangeSingle(contentChanged) {
            contentChangedStart = contentChanged.substr(0,1);
            var myString = window.location.href;
            var criteriaArray = myString.split('=');
            //check if the URL already contains some criteria:
            //if it already contains criteria:
            if(criteriaArray[1].indexOf('&') != -1) {
                if(criteriaArray[1].indexOf('&'+contentChangedStart) != -1) {
                        var currentURL = "'"+window.location+"'";
                        var n = currentURL.split("&");
                        var maxlength; 
                        maxlength = n.length;
                        for(i=1; i<maxlength; i++) {
                            if(n[i].substr(0,1) == '3') {
                                n[i] = "&"+contentChanged;
                            }
                            else {
                                n[i] = "&"+n[i];
                            }
                        }
                        newURL1 = n.join("");
                        newURL = newURL1.replace(/'/g,"");
                        window.location = newURL;
                }
                else {
                    criteriaArray[1] = criteriaArray[1]+'&'+contentChanged;
                    newURL = criteriaArray.join('=');
                    window.location = newURL;
                }
            }
            //if it doesnt contain any criteria:
            else { 
                criteriaArray[1] = criteriaArray[1]+'&'+contentChanged;
                newURL = criteriaArray.join('=');
                window.location = newURL;
            }
        }
        function formChangeDistance(contentChanged) {
            contentChangedStart = contentChanged.substr(0,1);
            var myString = window.location.href;
            var criteriaArray = myString.split('=');
            //check if the URL already contains some criteria:
            //if it already contains criteria:
            if(criteriaArray[0].indexOf('&') != -1) {
                if(criteriaArray[0].indexOf('&'+contentChangedStart) != -1) {
                        var currentURL = "'"+window.location+"'";
                        var n = currentURL.split("&");
                        var maxlength; 
                        maxlength = n.length;
                        for(i=1; i<maxlength; i++) {
                            if(n[i].substr(0,1) == '1') {
                                n[i] = "&"+contentChanged+"=";
                            }
                            else {
                                n[i] = "&"+n[i];
                            }
                        }
                        newURL1 = n.join("");
                        newURL = newURL1.replace(/'/g,"");
                        window.location = newURL;
                }
                else {
                    criteriaArray[0] = criteriaArray[0]+'&'+contentChanged+'=';
                    newURL = criteriaArray.join('=');
                    window.location = newURL;
                }
            }
            //if it doesnt contain any criteria:
            else { 
                criteriaArray[0] = criteriaArray[0]+'&'+contentChanged;
                newURL = criteriaArray.join('=');
                window.location = newURL;
            }
        }
        function changePostalCode() {
            var myString = window.location.href;
            var criteriaArray = myString.split('=');
            var postCodeArray = criteriaArray[0].split('/');
            if(postCodeArray[4].indexOf('13') != -1) {
                var currentPostalCode = postCodeArray[4].substr(0,6);
                var postcode = document.getElementsByName("postcode").item(0).value;
                var newURL = myString.replace(currentPostalCode, postcode);
                window.location = newURL;
            }
            else if(postCodeArray[4].indexOf('&') != -1) {
                var postcode = document.getElementsByName("postcode").item(0).value;
                var newPostalCodeDistance = postcode.concat(postCodeArray[4]);
                var newURL = myString.replace(postCodeArray[4], newPostalCodeDistance);
                window.location = newURL;
            }
            else {
                var postcode = document.getElementsByName("postcode").item(0).value;
                var newURL = criteriaArray[0]+postcode+'='+criteriaArray[1];
                window.location = newURL;
            }
        }
        document.onkeypress = stopRKey; 
        var webRoot;
        webRoot = 'http://test.adminfloris.nl/_include/imgFrontend/';
</script>


<div id="navigator">
    <div id="stepback">
        <a href="javascript:history.go(-1)" onmouseover="document.previous.src='http://test.adminfloris.nl/_include/imgFrontend/vorigestaphover.png'" onmouseout="document.previous.src='http://test.adminfloris.nl/_include/imgFrontend/vorigestap.png'">
            <?php echo '<IMG SRC= "'.FRONTEND_IMAGES_PATH.'vorigestap.png" name="previous" alt="Vorige Stap">'; ?>
        </a>
    </div>
    <div id="changedisplay1">
        <?php
            if($view == 'selSchoolList') { ?>
                <?php//Map Button?>
                <?php  echo'<a href="'.FRONTEND_LINK_ROOT.'selSchoolMap/'.$sideIdArray[2].'"';?> onmouseover="document.image3.src='http://test.adminfloris.nl/_include/imgFrontend/kaartlargehover.png'" onmouseout="document.image3.src='http://test.adminfloris.nl/_include/imgFrontend/kaartlarge.png'">
                    <?php
                    echo '<IMG SRC="'.FRONTEND_IMAGES_PATH.'kaartlarge.png" name="image3" alt="Kaart"/>';
                    ?>
                </a> 
            <?php }
            if($view == 'selSchoolMap') { ?>
                 <?php//List Button?>
                <?php echo'<a href="'.FRONTEND_LINK_ROOT.'selSchoolList/'.$sideIdArray[2].'"';?> onmouseover="document.image3.src='http://test.adminfloris.nl/_include/imgFrontend/lijstlargehover.png'" onmouseout="document.image3.src='http://test.adminfloris.nl/_include/imgFrontend/lijstlarge.png'">
                    <?php
                    echo '<IMG SRC="'.FRONTEND_IMAGES_PATH.'lijstlarge.png" name="image3" alt="Kaart"/>';
                    ?>
                </a>
            <?php }
            else {}
        ?>
    </div>
    <div class="criteriacolumn">
        <?php
        if($view == 'selSchoolMap' || $view == 'selSchoolList') {
           echo '<form method="post" name="refresh" id="refresh" action="">'; 
            ?>
         
            <fieldset class="f1">
                POSTCODE<br/><br/>
                <?php echo '<input name="postcode" class="postalcode" type="text" value="'.$postalCode.'"'; ?> onfocus="this.value=''" onchange="validate(this.name, this.value);" onblur="validate(this.name, this.value);" onmouseout="validate(this.name, this.value);"><input type="button" value="ZOEK" onclick="javascript:changePostalCode()" />
                
                <div id="postcodevoorbeeld">voorbeeld: 1315 AA</div>
                <div id="postcodemessage"></div>
                <div id="afstandkeuzelijst">
                    <fieldset class="f2">
                        <?php    
                            $i=0;
                            $test = new criteria;
                            //Assigns the content to the $content variable.
                            $content = $test->getTestCriteria();  
                            sort($content, SORT_REGULAR);
                            while(($content[$i]["criteriaType"]) == '1') {
                                 //defines the variable to check for in the array gotten from the URL criteria - sideIdArrayX
                                $checker = $content[$i]["criteriaType"]."-".$content[$i]["criteriaValueID"];
                                $changedValue = "'".$content[$i]["criteriaType"].'-'.$content[$i]["criteriaValueID"]."'";
                                echo '<input type="radio" name="afstand" value="" '; if($checker == $distance){echo "checked";} else{}echo ' class="afstandkeuzelijst" Onclick="JavaScript:formChangeDistance('; echo $changedValue; echo ');"/>'.$content[$i]["criteriaValueName"].'<br />';
                                $i++; 
                                
                            } 
                      
                        ?>

                     </fieldset>
                </div>
            </fieldset>
            <fieldset class="f1"> 
                <?php 
                    //Name for the 1st colum criteria
                    echo '<fieldset class="f1">'.$content[$i]["criteriaName"].'</fieldset>';
                ?> 
            </fieldset>
            <fieldset class="f2">
                <?php  
                    //While loop for the 1st column criteria
                    while(($content[$i]["criteriaType"]) == '2') {
                        //defines the variable to check for in the array gotten from the URL criteria - sideIdArrayX
                            $checker = $content[$i]["criteriaType"]."-".$content[$i]["criteriaValueID"];
                            //set the value for the 'onclick' function which refreshes the page:
                            $changedValue = "'".$content[$i]["criteriaType"].'-'.$content[$i]["criteriaValueID"]."'";
                        echo '<input  type="checkbox" name="'.$content[$i]["criteriaType"].''.$content[$i]["criteriaValueID"].'" value="&'.$content[$i]["criteriaType"].'-'.$content[$i]["criteriaValueID"].'"'; if(in_array($checker, $sideIdArrayX)){echo "checked";} else{echo '';}echo ' class="radiobutton" Onclick="JavaScript:formChange('; echo $changedValue; echo ');"/>'.$content[$i]["criteriaValueName"].'<br />' ;
                        $i++;                                   
                    } 
                ?>
            </fieldset>
           
            <fieldset class="f1">
                <?php
                    //name for the 2nd criteria column
                    echo '<fieldset class="f1">'.$content[$i]["criteriaName"].'</fieldset>';
                ?>
            </fieldset>
            <fieldset class="f2">
                <?php
                    //While loop for the 2nd column criteria  
                    while(($content[$i]["criteriaType"]) == '3') {
                        //defines the variable to check for in the array gotten from the URL criteria - sideIdArrayX
                            $checker = $content[$i]["criteriaType"]."-".$content[$i]["criteriaValueID"];
                            $changedValue = "'".$content[$i]["criteriaType"].'-'.$content[$i]["criteriaValueID"]."'";
                        echo '<input type="radio" name="students" value="&'.$content[$i]["criteriaType"].'-'.$content[$i]["criteriaValueID"].'"'; if(in_array($checker, $sideIdArrayX)){echo "checked";} else{echo '';}  echo' class="radiobutton" Onclick="JavaScript:formChangeSingle('; echo $changedValue; echo ');"/>'.$content[$i]["criteriaValueName"].'<br />';
                        $i++;
                    } 
                ?>
            </fieldset>
            <fieldset class="f1"> 
                <?php
                    //name for the 2nd criteria column
                    echo '<fieldset class="f1">'.$content[$i]["criteriaName"].'</fieldset>';
                ?>
            </fieldset>
            <fieldset class="f2"> 
                <?php  
                     //While loop for the 3rth column criteria
                    while(($content[$i]["criteriaType"]) == '4') {
                        //defines the variable to check for in the array gotten from the URL criteria - sideIdArrayX
                            $checker = $content[$i]["criteriaType"]."-".$content[$i]["criteriaValueID"];
                            $changedValue = "'".$content[$i]["criteriaType"].'-'.$content[$i]["criteriaValueID"]."'";
                        echo '<input type="checkbox" name="'.$content[$i]["criteriaType"].''.$content[$i]["criteriaValueID"].'" value="&'.$content[$i]["criteriaType"].'-'.$content[$i]["criteriaValueID"].'"';   if(in_array($checker, $sideIdArrayX)){echo "checked";} else{echo '';} echo' class="radiobutton" Onclick="JavaScript:formChange('; echo $changedValue; echo ');"/>'.$content[$i]["criteriaValueName"].'<br />' ;
                        $i++;                                   
                    } 
                ?>
            </fieldset>
         </form>
            <?php
            
        }
        else { ?>
            <fieldset class="f1">
                <br/><br/>
               <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
            </fieldset>
        <?php }
        ?>
    </div>
</div>