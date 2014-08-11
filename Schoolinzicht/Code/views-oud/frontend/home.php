<?php 
   
//Designed and written in the year 2012, for ASG, by:
//Peter van Kleef, Richard Floris & Pepijn de Vries.
        
require_once MODEL_CRITERIA;
require_once MODEL_MENU;
    $pageName = 'home';

$test = new criteria;
$i=0;
$c=0;
$a=0;
$b=0;
$content = $test->getTestCriteria();  
sort($content, SORT_REGULAR);

//Sorts the array to display correctly from low to high on the screen.

//Checks if there has been criteria submitted and puts the $post array apart from the selected view into one variable to pass in a URL

    if(isset($_POST)){
        $postcode = $_POST['postcode'];
        $afstand = $_POST['afstand'];
        unset($_POST['postcode']);
        unset($_POST['afstand']);
        foreach($_POST as $value){

            $passTo = $passTo.$value;
            $c++;

        }
     }

    $passTo = str_replace("_list", "", $passTo);
    $passTo = str_replace("_map", "", $passTo);




    //Makes sure the user gets forwarded to the desired view.
    if($_POST["submitlist"] == '_list'){
    header('Location: '.FRONTEND_LINK_ROOT.'selSchoolList/'.$postcode.$afstand.'='.$passTo);    
    }
//    if($_POST["submittile"] == '_tile'){
//    header('Location: '.FRONTEND_LINK_ROOT.'selSchooTile/'.$passTo.'');    
//    }
    if($_POST["submitmap"] == '_map'){
    header('Location: '.FRONTEND_LINK_ROOT.'selSchoolMap/'.$postcode.$afstand.'='.$passTo);    
    }





//Assigns the content to the $contentJS variable. for Javascript
$contentJS = $test->getTestCriteria();  


//puts the distance PHP array values in a javascript array
echo '<script type="text/javascript">'; 
echo 'var transition=new Array();';
echo '</script>';
foreach($contentJS as $value){
    if($contentJS[$b]["criteriaType"] == "1"){ 
        echo '<script type="text/javascript">'; 
        echo 'transition['.$a.']="'.$contentJS[$b]["criteriaValue"].'";';
        echo '</script>';

    $b++;    $a++;  
    }else{$b++;}

}
                       
                                 
//  $criteriavalues = new BaseModel;
//  $criteria = $criteriavalues->($getFunction);
//  $test = new criteria;
//  $content = $test->showItems($getFunction);
//  print_r($content);
             
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <?php echo'<link rel="stylesheet" type="text/css" href="'.CSSF_HOME.'" />';
               echo'<link rel="stylesheet" type="text/css" href="'.CSSF_HEADER.'" />';
               echo'<link rel="stylesheet" type="text/css" href="'.CSSF_HELPTEXT.'" />'; 
               echo'<link rel="stylesheet" type="text/css" href="'.CSSF_DEFAULT.'" />'; ?>
        <!--[if IE]><link rel="stylesheet" type="text/css" href="../../_include/css/frontend/IEoverwrite.css"/><![endif]-->
        <title>SCHOOLINZICHT</title>
        <script type="text/javascript"> 

            // disable the ENTER key, a user can't submit the form by
            // presseing enter:
            function stopRKey(evt) {
                var evt = (evt) ? evt : ((event) ? event : null);
                var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
                if ((evt.keyCode == 13) && (node.type=="text"))  {return false;}
            }
            document.onkeypress = stopRKey; 
        </script>
    </head>
    <body class="body">
        <div id="header">
            <div id="headercontainer">      
                <?php include_once("views/components/frontendHeader.php"); ?>
            </div>
        </div>
        <div id="helptext">     
            <?php include_once("views/components/infotext.php"); ?>
        </div>
        <div id="content">
            <form method="post" action="">
                <div id="step1container">
                    <div id="step1header">
                        <div class="stepimage"><?php echo '<img src="'.FRONTEND_IMAGES_PATH.'step1.png" alt="" height="55" width="55" />'?></div>
                        <div class="steptitle">Selecteer uw afstand</div>
                    </div>
                    <div id="step1column">
                        <fieldset class="f4">
                            POSTCODE &nbsp;<input name="postcode" class="postalcode" type="text" value=""/>
                            <div class="postcodevoorbeeld">Voorbeeld: 1315AA<br/><br/></div>
                            <div id="afstandskeuzelijst">
                                <fieldset class="f2">
                                    <?php
                                    $i=0;
                                    //$content = $test->getTestCriteria();  
                                    //Sorts the array to display correctly from low to high on the screen.

                                    // sort($content, SORT_REGULAR);
                                    //Foreach/while loop for the distancecriteria
                                    foreach($content as $value) {
                                        while(($content[$i]["criteriaType"]) == '1') {
                                            echo '<input type="radio" name="afstand" value="&'.$content[$i]["criteriaType"].'-'.$content[$i]["criteriaValueID"].'" class="distancelist" />'.$content[$i]["criteriaValueName"].'<br />';
                                            $i++;
                                        }         
                                    }    
                                    ?>
                                </fieldset>
                                <div class="postcodevoorbeeld">Wanneer er geen postcode geselecteerd is wordt er vanuit het centrum van Almere gerekend.</div>
                            </div>
                        </fieldset>
                    </div>
                </div>
                <div id="step2container">
                    <div id="step2header">
                        <div id="step2image"><?php echo '<img src="'.FRONTEND_IMAGES_PATH.'step2.png" alt="" height="55" width="55" />'?></div>
                        <div id="step2title">Selecteer uw filtercriteria</div>
                    </div>
                    <div class="step2column">
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
                                echo '<input  type="checkbox" name="'.$content[$i]["criteriaType"].''.$content[$i]["criteriaValueID"].'" value="&'.$content[$i]["criteriaType"].'-'.$content[$i]["criteriaValueID"].'" class="radiobutton" />'.$content[$i]["criteriaValueName"].'<br />' ;
                                $i++;                                   
                            }  
                            ?>
                        </fieldset>  
                    </div>
                    <div class="step2column">
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
                                    echo '<input type="radio" name="students" value="&'.$content[$i]["criteriaType"].'-'.$content[$i]["criteriaValueID"].'"  class="radiobutton" />'.$content[$i]["criteriaValueName"].'<br />';
                                    $i++;
                                } 
                            ?>
                        </fieldset>
                    </div>
                    <div class="step2column">
                        <fieldset class="f1"> 
                            <?php
                            //name for the 2nd criteria column
                            echo '<fieldset class="f1">'.$content[$i]["criteriaName"].'</fieldset>';
                            echo '';
                            ?>
                        </fieldset>
                        <fieldset class="f2"> 
                            <?php  
                            //While loop for the 3rth column criteria
                            while(($content[$i]["criteriaType"]) == '4') {
                                echo '<input type="checkbox" name="'.$content[$i]["criteriaType"].''.$content[$i]["criteriaValueID"].'" value="&'.$content[$i]["criteriaType"].'-'.$content[$i]["criteriaValueID"].'" class="radiobutton" />'.$content[$i]["criteriaValueName"].'<br />' ;
                                $i++;                                   
                            } 
                            ?>
                        </fieldset>
                    </div>
                </div>
                <div id="step3container">
                    <div id="step3header">
                        <div class="stepimage"><?php echo '<img src="'.FRONTEND_IMAGES_PATH.'step3.png" alt="" height="55" width="55" />'?></div>
                        <div class="steptitle">Selecteer uw weergave</div>
                    </div>
                    <div id="step3column">
                        <input type="submit" name="submitlist" class="submitlist" value="_list" />
                        <div id="displaysubmitbutton">
                            <input type="submit" name="submitmap" class="submitmap" value="_map" />
                        </div>
                    </div>
                </div>
            </form>
            
        </div>
    </body>
</html> 