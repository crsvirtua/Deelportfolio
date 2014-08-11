<?php

//Designed and written in the year 2012, for ASG, by:
//Peter van Kleef, Richard Floris & Pepijn de Vries.

require_once MODEL_BASEMODEL;
require_once INCLUDE_QUERYMANAGER;

Class Criteria extends baseModel{
    public $critID;
    public $description;
    public $value;
    
    //ShowItems function from basemodel
    function getTestCriteria() {
          $contentthroughput = new queryManager;
          $content = $contentthroughput->getCriteria();

          return $content;
    }
    
    //the following function removes schools that don't 
    //match the user defined criteria 
    //(criteriaArray = selected criteria, schoolinfo = all schools):
    function matchCriteria($criteriaArray, $schoolinfo, $view, $postcode, $afstand) {
        $contenttroughput = new queryManager;
        //sets the default value of i to 0,
        //i is needed for the first foreach loop
        //which cuts the numbers and puts a value to it.
        $i=0;
        //sets the default value of p to 0,
        //p is needed for the second foreach loop
        //which puts the value of every criterium in a new array
        //along with the ID of a value (1,2,3,4) in another aray.
        $p=0;
        $z=0;
        $x=0;
        $c=0;
        $v=0;
        $f=0;
        //sets the default value of o to 0,
        //o is needed for third foreach loop
        //in which o represents the schoolnumber
        $o=0;
        //this foreach loop cuts the criteria variable
        //that we got from the URL into seperate peaces;
        //the firstString is the criteriaSort and
        //the finalString is the criteriaValueNumber
        

            $postCode = $postcode;
            $afstand = $afstand;
            
            $afstandIDsplit = explode('-', $afstand);
            $afstandID = $afstandIDsplit[1];
            
            $afstandValue = $contenttroughput->getCriteriaInfo($afstandID);
        
            $afstand = $afstandValue[0]['criteriaValue'];
            
        foreach($criteriaArray as $value) {
            //split the value (devided by -)into two seperate strings:
            $arrayString = explode("-", $value);
            
            $firstString[$i] = $arrayString[0];
            $finalString[$i] = $arrayString[1];
            
            
            //download the value of each criteria(where number=ID)
                $content[$i] = $contenttroughput->getCriteriaInfo($finalString[$i]);
                $i++;
            
        }
        $criterium1[$z] = $postCode;
        $criterium1[$z+1] = $afstand;

        
        if(!empty($criterium1[0]) && !empty($criterium1[1])) {
            $criteriumID[0] = 1;
            $p=1;
        }
        
        //set two arrays: the first holds all values
        //the second holds all criteriaSorts:
        foreach($content as $value) {

            $criteriumID[$p] = $value[0]['criteriaType'];

            if($criteriumID[$p] == 2) {
                $criterium2[$x] = $value[0]['criteriaValue'];
                $x++;
            }
            elseif($criteriumID[$p] == 3) {
                $criterium3[$c] = $value[0]['criteriaValue'];
                $c++;
            }
            elseif($criteriumID[$p] == 4) {
                $criterium4[$v] = $value[0]['criteriaValue'];
                $v++;
            }
            $p++;
        }
 
        $g=0;
        foreach($schoolinfo as $value) {
            //retreive XY coordinates:
            $BRIN = $value['BRIN'];
            $schoolXY = $contenttroughput->getSchoolPostalCodeXY($BRIN);
            
            //put XY coordinates in the schoolinfo array:
            $schoolinfo[$g]['xCoordinate'] = $schoolXY[0]['xCoordinate'];
            $schoolinfo[$g]['yCoordinate'] = $schoolXY[0]['yCoordinate'];
            
            $getFunction = 'getStudentTotal'; 
            
            $baseModel = new BaseModel;
            // get the current year and detract 2 to get the desired year from the DB
            $today = date("Y");     
            $year = $today - 1;
            $NOschoolStudents = $baseModel->showItem($getFunction, $BRIN, $year); 
            
            $schoolinfo[$g]["studentNO"] = $NOschoolStudents[0]["totalStudents"];
            
            $g++;
        }
        $gekozenPostcode = strtoupper($postCode);
        
        $queryManager = new queryManager;
        $postalCodeXY = $queryManager->getPostalCodeInfo($gekozenPostcode);
        
        
        //count the number of times a specific criterium has
        //been selected:
        //print_r($criteriumID);
        //if there are no criteria selected: do not alter
        //the 'schoolinfo' array, which holds all schools:
        if(empty($criterium1)&& empty($criterium2) && empty($criterium3) && empty($criterium4)) { }
        
        //else, alter the schoolinfo array, delete items
        //that do not match selected criteria:
        else {
            //for each school in the schoolinfo array:
            foreach($schoolinfo as $value) {
                //set the default value of u to 0,
                //u is needed for the fourth and last foreach:
                $u=0;
                
                //for each different criterium:
                foreach($criteriumID as $value1) {
                    
                    //filter the criteria according to what they are:
                    //1 for postalcode and distance,
                    //2 for schoolType,
                    //3 for Number of students,
                    //4 for denominatie:
                    if(!empty($criterium1[0]) && !empty($criterium1[1])) {
                        //determine the differences in both X and Y between the postalcode and the school:
                        $diffX = $postalCodeXY[0]['xCoordinate'] - $value['xCoordinate'];
                        $diffY = $postalCodeXY[0]['yCoordinate'] - $value['yCoordinate'];
                        //perform a Pythagoras function on those differences:
                        $verschilX = pow(abs($diffX), 2);
                        $verschilY = pow(abs($diffY), 2);
                        $afstandMeters = sqrt($verschilX + $verschilY);
                        //afstandMeters = the actual distance, which we use
                        //BUT for a user it is much more interesting to see 
                        //distance in KM, therefor:
                        $afstandKilometers = $afstandMeters/1000;   
                        //the above gives a long number, which we want to have rounded to for example 3.6
                        //therefor we use the 0.1 rounder and the round function, as seen below:
                        $roundTo = 0.1;
                        $afstandKMAfgerond = round($afstandKilometers / $roundTo) * $roundTo;
                        
                        //if the afstandKMAfgerond is for example 1 we want to add '.0' to it;
                        //so we make 1.0 of the value 1:
                        if(strlen($afstandKMAfgerond) == '1') {
                            $afstandKMAfgerond = $afstandKMAfgerond.'.0';
                        }
                        
                        if($afstandMeters <= $criterium1[1]) { $schoolinfo[$o]['distance'] = $afstandKMAfgerond; }
                        else { unset($schoolinfo[$o]); }
                    }
                    
                    if($criteriumID[$u] == '2') {
                        $count = count($criterium2);

                        //switch through the options:
                        //for each different number of criteria in one sort
                        //there is a different variable (with each value one
                        //extra is needed):
                        switch($count) {
                            case 1:
                                $criteriumFunc = '($schoolinfo[$o]["educationType"] == $criterium2[0])';
                                break;
                            case 2:
                                $criteriumFunc = '($schoolinfo[$o]["educationType"] == $criterium2[0]) OR ($schoolinfo[$o]["educationType"] == $criterium2[1])';
                                break;
                            case 3:
                                $criteriumFunc = '($schoolinfo[$o]["educationType"] == $criterium2[0]) OR ($schoolinfo[$o]["educationType"] == $criterium2[1]) OR ($schoolinfo[$o]["educationType"] == $criterium2[2])';
                                break;
                            case 4:
                                $criteriumFunc = '($schoolinfo[$o]["educationType"] == $criterium2[0]) OR ($schoolinfo[$o]["educationType"] == $criterium2[1]) OR ($schoolinfo[$o]["educationType"] == $criterium2[2]) OR ($schoolinfo[$o]["educationType"] == $criterium2[3])';
                                break;
                            case 5:
                                $criteriumFunc = '($schoolinfo[$o]["educationType"] == $criterium2[0]) OR ($schoolinfo[$o]["educationType"] == $criterium2[1]) OR ($schoolinfo[$o]["educationType"] == $criterium2[2]) OR ($schoolinfo[$o]["educationType"] == $criterium2[3]) OR ($schoolinfo[$o]["educationType"] == $criterium2[4])';
                                break;
                            case 6:
                                $criteriumFunc = '($schoolinfo[$o]["educationType"] == $criterium2[0]) OR ($schoolinfo[$o]["educationType"] == $criterium2[1]) OR ($schoolinfo[$o]["educationType"] == $criterium2[2]) OR ($schoolinfo[$o]["educationType"] == $criterium2[3]) OR ($schoolinfo[$o]["educationType"] == $criterium2[4]) OR ($schoolinfo[$o]["educationType"] == $criterium2[5])';
                                break;
                        }
                        //IF the criterium is in this particular school: do nothing:
                        if(eval("return $criteriumFunc;")) {}  
                        //IF the criterium is not present in this particular school,
                        //remove the school from the schoolinfo array (which by default
                        //holds ALL schools):
                        else {
                            unset($schoolinfo[$o]);
                        }
                    }

                    elseif($criteriumID[$u] == '3') {
                        
                        //IF the criterium is in this particular school: set the number of students:
                        if(($schoolinfo[$o]["studentNO"]) < ($criterium3[0])) { 

                        }  
                        //IF the criterium is not present in this particular school,
                        //remove the school from the schoolinfo array (which by default
                        //holds ALL schools):
                        else {
                            unset($schoolinfo[$o]);
                        }
                    }
                                        
                    elseif($criteriumID[$u] == '4') {
                        $count = count($criterium4);

                        //switch through the options:
                        //for each different number of criteria in one sort
                        //there is a different variable (with each value one
                        //extra is needed):
                        switch($count) {
                            case 1:
                                $criteriumFunc = '($schoolinfo[$o]["boardName"] == $criterium4[0])';
                                break;
                            case 2:
                                $criteriumFunc = '($schoolinfo[$o]["boardName"] == $criterium4[0]) OR ($schoolinfo[$o]["boardName"] == $criterium4[1])';
                                break;
                            case 3:
                                $criteriumFunc = '($schoolinfo[$o]["boardName"] == $criterium4[0]) OR ($schoolinfo[$o]["boardName"] == $criterium4[1]) OR ($schoolinfo[$o]["boardName"] == $criterium4[2])';
                                break;
                            case 4:
                                $criteriumFunc = '($schoolinfo[$o]["boardName"] == $criterium4[0]) OR ($schoolinfo[$o]["boardName"] == $criterium4[1]) OR ($schoolinfo[$o]["boardName"] == $criterium4[2]) OR ($schoolinfo[$o]["boardName"] == $criterium4[3])';
                                break;
                            case 5:
                                $criteriumFunc = '($schoolinfo[$o]["boardName"] == $criterium4[0]) OR ($schoolinfo[$o]["boardName"] == $criterium4[1]) OR ($schoolinfo[$o]["boardName"] == $criterium4[2]) OR ($schoolinfo[$o]["boardName"] == $criterium4[3]) OR ($schoolinfo[$o]["boardName"] == $criterium4[4])';
                                break;
                            case 6:
                                $criteriumFunc = '($schoolinfo[$o]["boardName"] == $criterium4[0]) OR ($schoolinfo[$o]["boardName"] == $criterium4[1]) OR ($schoolinfo[$o]["boardName"] == $criterium4[2]) OR ($schoolinfo[$o]["boardName"] == $criterium4[3]) OR ($schoolinfo[$o]["boardName"] == $criterium4[4]) OR ($schoolinfo[$o]["boardName"] == $criterium4[5])';
                                break;
                        }
                        //IF the criterium is in this particular school: do nothing:
                        if(eval("return $criteriumFunc;")) {}  
                        //IF the criterium is not present in this particular school,
                        //remove the school from the schoolinfo array (which by default
                        //holds ALL schools):
                        else {
                            unset($schoolinfo[$o]);
                        }
                    }
                  
                $u++;
                }
                
            $o++;
            }
        }
        
    if($view == 'selSchoolMap') {
        
        echo '<script type="text/javascript">'; 
            echo "var mapCenterPostcode = \"$postCode\";";
            echo "var mapCenterAfstand = \"$gekozenAfstand\";";
        echo '</script>';
        
        echo '<script type="text/javascript">';
            echo 'var schoolName = new Array();';
            echo 'var schoolAdres = new Array();';
            echo 'var schoolBRIN = new Array();';
            echo 'var schoolLeerlingen = new Array();';
            echo 'var schoolOC = new Array();';
            echo 'var schoolLat = new Array();';
            echo 'var schoolLong = new Array();';
        echo '</script>'; 
        
        echo '<script type="text/javascript">';
        
        $b=0;
        
        foreach($schoolinfo as $value) {
            
            echo 'schoolName['.$b.'] = "'.$value['schoolName'].'";'; 
            echo 'schoolAdres['.$b.'] = "'.$value['address'].','.$value['postalCode'].', Almere";';
            echo 'schoolLeerlingen['.$b.'] = "'.$value['studentNO'].'";'; 
            
            echo 'schoolBRIN['.$b.'] = "'.$value['BRIN'].','.'";';
            
            echo 'schoolLat['.$b.'] = "'.$value['schoolLat'].'";';
            echo 'schoolLong['.$b.'] = "'.$value['schoolLong'].'";';
            
            $b++;
            
        }
        
        echo '</script>';
    }
    //return either the full schoolinfo if no criteria were selected,
    //or return only the remaining schools, if criteria were matched:
    //print_r($schoolinfo);
    return $schoolinfo;
    }
}
?>