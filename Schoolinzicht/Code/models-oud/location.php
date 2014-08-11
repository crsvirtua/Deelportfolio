<?php

//Designed and written in the year 2012, for ASG, by:
//Peter van Kleef, Richard Floris & Pepijn de Vries.


//This file is no longer needed, this function is now built into
//the criteria function in the criteria Model.

require_once MODEL_BASEMODEL;
require_once INCLUDE_QUERYMANAGER;

Class Location extends baseModel{
    //Calculates the distance between de schools and selected postal code for the maps and list view.
    function calculateDistance($gekozenAfstand, $gekozenPostcode){
        

            echo '<script type="text/javascript">'; 
                echo "var mapCenterPostcode = \"$gekozenPostcode\";";
                echo "var mapCenterAfstand = \"$gekozenAfstand\";";
            echo '</script>';
            
        $contentthroughput = new queryManager;
        $content = $contentthroughput->getPostalCodeInfo($gekozenPostcode);
        
        $gekozenPostcodeY = $content[0]['yCoordinate'];
        $gekozenPostcodeX = $content[0]['xCoordinate'];
        
        $schoolPostCodeXY = $contentthroughput->getSchoolPostalCode();
        
        $nums = count($schoolPostCodeXY);
        
        echo '<script type="text/javascript">';
            echo 'var schoolName = new Array();';
            echo 'var schoolAdres = new Array();';
            echo 'var schoolOC = new Array();';
            echo 'var schoolLat = new Array();';
            echo 'var schoolLong = new Array();';
        echo '</script>';
        
        $p = '0';
        
        for($i=0; $i<=$nums; $i++) {
            
            $schoolPostcodeX = $schoolPostCodeXY[$i]['xCoordinate'];
            $schoolPostcodeY = $schoolPostCodeXY[$i]['yCoordinate'];
            $schoolLat = $schoolPostCodeXY[$i]['schoolLat'];
            $schoolLong = $schoolPostCodeXY[$i]['schoolLong'];
            $diffX = $gekozenPostcodeX-$schoolPostcodeX;
            $diffY = $gekozenPostcodeY-$schoolPostcodeY;
            $verschilX = pow(abs($diffX), 2);
            $verschilY = pow(abs($diffY), 2);
            $afstand = sqrt($verschilX + $verschilY);
            
            $afstandArray[$i]['afstand'] = $afstand;
            
            if($afstandArray[$i]['afstand'] < $gekozenAfstand && ($schoolLat != '' && $schoolLong != '')) {
                
                echo '<script type="text/javascript">';
                    
                    echo 'schoolName['.$p.'] = "'.$schoolPostCodeXY[$i]['schoolName'].'";'; 
                    echo 'schoolAdres['.$p.'] = "'.$schoolPostCodeXY[$i]['adress'].','.$schoolPostCodeXY[$i]['postalCode'].', Almere";';
                    
                    echo 'schoolLat['.$p.'] = "'.$schoolPostCodeXY[$i]['schoolLat'].'";';
                    echo 'schoolLong['.$p.'] = "'.$schoolPostCodeXY[$i]['schoolLong'].'";';
                    
                    //echo 'schoolOC['.$p.'] = "'.$schoolPostCodeXY[$i]['educationType'].'";';
                    //bovenstaande variable er uit gelaten, werkt niet (wss te maken met foreign key)

                echo '</script>';
                
                $p++;
            }
        }
    }       
}
?>