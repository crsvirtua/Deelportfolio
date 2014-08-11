<?php
require_once MODEL_BASEMODEL;
require_once INCLUDE_QUERYMANAGER;

class Tab extends BaseModel{
   
    
  
//    //Translates the php array to a javascript array
//   function phpToJava($array){
//       $b = 0;
//       $a = 0;
//       echo '<script type="text/javascript">'; 
//       echo 'var transition=new Array();';
//       echo '</script>';
//          echo '<script type="text/javascript">'; 
//       foreach($array as $value){
//      
//     
//        echo 'transition['.$a.']="'.$array[$b].'";';
//       
//
//        $b++;    $a++;  
//        }
//    echo '</script>';
//      
//  }

    //SStill needs to be remodeled after the other calculation functions
//This function has nested if else statements depending on the tabID, to perform the correct calculation and query.
    //Calculates the area student hail from - Tab 1 - Graph 1
   function areaCalc($schoolID, $schoolGraph){
    $base = new BaseModel;
    // get the current year and detract 2 to get the desired year from the DB
    $today = date("Y");     
    $year = $today - 1;
     $month = date("m");
    if($month <= 8){
        $year= $today-1;
       
    }else{
        $year = $today;
       
    
    }  
     $i=0;
     
        //Retrieves the data
         $getFunction = 'getStudentArea';  
         $area = $base->showItem($getFunction, $schoolID, $year);
    
            foreach($area as $value){
                //Adds up all the totals into one total for further calculations
                $total = $total + $area[$i]["total"];
                //Adds up the first 5 (including 0) values for further calculations
                if($i <= 4){ 
                    $result = $result + $area[$i]["total"];
                }
                $i++;               
            }
            //Calculations the remaining totals
            $remaining = $total - $result;
             
              $i=0;
              foreach($area as $value){
               
                  //puts all the remaining values in a 5th "Overige" Value
                    if($i == 5){
                    $area[$i]["total"] = $remaining;
                    $area[$i]["WijkNr"] = "999";
                    $area[$i]["areaName"] = "Overige";
                    }
                    //Cleans up the array after the 5th value
                if($i >= 6){
                    unset($area[$i]);
                }   
                $i++;
              }
              $i=0;
             
              foreach($area as $value){
                  //Percentage calculation for further possible use
                  $area[$i]["percentage"] = $area[$i]["total"] / $total * 100;
              $i++;
              } 
              //safeguard for schools that do not have a remaining section.
              if(!isset($area[5])){
                  $area[5]["total"] = 0;
                  $area[5]["WijkNr"] = "999";
                  $area[5]["areaName"] = "Overige";
                  $area[5]["percentage"] = 0;
              }
                    //Define the arrays
                      echo '<script type="text/javascript">'; 
                      echo 'var transitionValues=new Array();';
                      echo 'var transitionPercentage=new Array();';
                      echo 'var transitionKeys=new Array();';
             
                      echo '</script>';
                      echo '<script type="text/javascript">'; 
                    
                    $i=0;
                    foreach($area as $value){
      
                        // Transition from PHP arrays to JS
                    echo 'transitionValues['.$i.']='.$area[$i]["total"].';';
                    echo 'transitionKeys['.$i.']="'.$area[$i]["areaName"].'";';
                    echo 'transitionPercentage['.$i.']='.$area[$i]["percentage"].';';
                         $i++;  
                    }
                    
                   
                   
                    echo 'var total = '.$total.';';
                    echo 'var areaYear = '.$year.';';
                  //  echo 'var totalstudents'.$schoolGraph.' = '.$total.';';
                   // echo 'var year'.$schoolGraph.' = "'.$year.';';
                    echo '</script>';
                
                   
                    //Checks if there are values in the array to check if a graph can be generated
                   if($total !=0 && $year !=0 && isset($area[0]) ){
                       $noGraph = "false";
                      
                   }
                   elseif(empty($area[1])){
                       $noGraph = "true";
                   }
                   
                  
                 echo '<script>'; 
                 echo 'var noGraph = '.$noGraph.'';
                 echo '</script>';
   }
   //Retrieves the Inspectionresults - Tab 6
   function inspectionResults($schoolID, $schoolGraph){
         $base = new BaseModel;
         $getFunction = 'getInspectionResults';
         $inspection = $base->showitem($getFunction, $schoolID);
         $empty = "empty";
         if(!empty($inspection[0]["inspectionResultID"])){
          return $inspection;
         }else{ return $empty; }        
   }
   //Retrieves the businessData - Tab 7
   function businessData($schoolID, $schoolGraph){
        $base = new BaseModel;
      
         $empty = "empty";
         $getFunction = 'getBusinessData';  
         $business = $base->showItem($getFunction, $schoolID);

         $totalFTE = $business[0]["directieledenFTE"] + $business[0]["onderwijzendPersoneelFTE"] + $business[0]["onderwijsOndersteunendPersoneelFTE"];
         $totalPers = $business[0]["directieleden"] + $business[0]["onderwijzendPersoneel"] + $business[0]["onderwijsOndersteunendPersoneel"];
         $business[0]["totalFTE"] = $totalFTE;  
         $business[0]["totalPers"] = $totalPers;  
 
          if(empty($business[0]["totalFTE"]) && empty($business[0]["totalPers"])){
          
          return $empty;
         }else{ return $business; }
}

//Calculates the DLE and retrieves the DL - Tab 3 - Graph 1
// Original plan was to have 2 instances of the data compared to each other so that only the maximum of each type would be retrieved, however it seems to crash the interface when used in phpmyadmin hence it was reformed in php
function getDLE($schoolID, $schoolGraph){
    $base = new BaseModel;
    $today = date("Y");
    $month = date("m");
    $norm = 100;
    $TLW = 83;
    if($month <= 8){
        $year= $today-1;
        $year= $year."-".$today;
         $year2 = $today-3;
        $year21 = $today-2;
        $year2 = $year2."-".$year21;
    }else{
        $year = $today;
        $year = $year."-".$today+1;
        $year2 = $today-2;
        $year21 = $today-1;
        $year2 = $year2."-".$year21;
    
    }  
    $type1 = "Rek. en Wisk.";
    $type2 = "Spelling";
    $type3 = "Begr.lezen";
     $getFunction = "getDLEData2";
    $DLData = $base->showItems($getFunction, $schoolID, $year2, $year);
   if(isset($DLData[1])){ 
    $DLECheck = "true";
    //print_r($DLData);
//   
//    $count = count($DLData);
//    //Loop to indicate and add the values that are not the highest of their type for the particular student. adds up in a string with &number&number which will be exploded later.
//       for($i=0; $i<= $count; $i++){
//           
//                    if($i>0){
//                    $past=$i-1;
//                        if($DLData[$i]["StudentID_ESIS"] == $DLData[$past]["StudentID_ESIS"]){
//                                if($DLData[$i]["testType"] == $DLData[$past]["testType"]){
//                                    if($DLData[$i]["DLE"] > $highest){
//                                        $pos = $highpos;
//                                        $highest = $DLData[$i]["DLE"];
//
//                                        $highpos = $i;
//                                    }
//
//                                    elseif($DLData[$i]["DLE"] <= $highest){
//                                        $pos = $i;
//                                    }
//
//                                    if($pos != 0){
//                                        $tbr = $tbr."&".$pos;
//                                        $pos = 0;
//                                    }
//
//
//                                }else{
//                                    $highest=0;
//
//                                }
//
//                        
//                    }
//                }
//}
//
//        $tbrarray = explode("&", $tbr);
//        unset($tbrarray[0]);
////Cleans up the array with values that have been determined by the previous loop
//        foreach($tbrarray as $value){
//            unset($DLData[$value]);
//        }
   
//        $test = count($DLData);
//        for($i=0; $i <= $test; $i++){
//            echo "<br />";
//            print_r($DLData[$i]);
//            echo "<br />";
//        }
//print_r($DLData);

//Adds up the total DLE, DL and counts for all of the different types and grades
  foreach($DLData as $value){
      if($value["gradeYear"] == 3){
        if($value["testType"] == $type1){
                        $type1Rend3 = $type1Rend3+$value["Rendement"];
                        $type1count3 = $type1count3+1;
        }elseif($value["testType"] == $type2){
                        $type2Rend3 = $type2Rend3+$value["Rendement"];
                        $type2count3 = $type2count3+1;
        }elseif($value["testType"] == $type3){
           
                        $type3Rend3 = $type3Rend3+$value["Rendement"];
                        $type3count3 = $type3count3+1;
        }
                }elseif($value["gradeYear"] == 4){
                    if($value["testType"] == $type1){
                                   $type1Rend4 = $type1Rend4+$value["Rendement"];
                                    $type1count4 = $type1count4+1;
                    }elseif($value["testType"] == $type2){
                                    $type2Rend4 = $type2Rend4+$value["Rendement"];
                                    $type2count4 = $type2count4+1;
                    }elseif($value["testType"] == $type3){
                                    $type3Rend4 = $type3Rend4+$value["Rendement"];
                                    $type3count4 = $type3count4+1;
                    }
                            }elseif($value["gradeYear"] == 5){
                                if($value["testType"] == $type1){
                                                $type1Rend5 = $type1Rend5+$value["Rendement"];
                                                $type1count5 = $type1count5+1;
                                }elseif($value["testType"] == $type2){
                                                $type2Rend5 = $type2Rend5+$value["Rendement"];
                                                $type2count5 = $type2count5+1;
                                }elseif($value["testType"] == $type3){
                                                $type3Rend5 = $type3Rend5+$value["Rendement"];
                                                $type3count5 = $type3count5+1;
                                }
                                        }elseif($value["gradeYear"] == 6){
                                            if($value["testType"] == $type1){
                                                            $type1Rend6 = $type1Rend6+$value["Rendement"];
                                                            $type1count6 = $type1count6+1;
                                            }elseif($value["testType"] == $type2){
                                                           $type2Rend6 = $type2Rend6+$value["Rendement"];
                                                            $type2count6 = $type2count6+1;
                                            }elseif($value["testType"] == $type3){
                                                           $type3Rend6 = $type3Rend6+$value["Rendement"];
                                                            $type3count6 = $type3count6+1;
                                            }
                                                    }elseif($value["gradeYear"] == 7){
                                                        if($value["testType"] == $type1){
                                                                        $type1Rend7 = $type1Rend7+$value["Rendement"];
                                                                        $type1count7 = $type1count7+1;
                                                        }elseif($value["testType"] == $type2){
                                                                       $type2Rend7 = $type2Rend7+$value["Rendement"];
                                                                        $type2count7= $type2count7+1;
                                                        }elseif($value["testType"] == $type3){
                                                                        $type3Rend7 = $type3Rend7+$value["Rendement"];
                                                                        $type3count7 = $type3count7+1;
                                                        }
                                                                        }elseif($value["gradeYear"] == 8){
                                                                            if($value["testType"] == $type1){
                                                                                            $type1Rend8 = $type1Rend8+$value["Rendement"];
                                                                                            $type1count8 = $type1count8+1;
                                                                            }elseif($value["testType"] == $type2){
                                                                                            $type2Rend8 = $type2Rend8+$value["Rendement"];
                                                                                            $type2count8 = $type2count8+1;
                                                                            }elseif($value["testType"] == $type3){
                                                                                             $type3Rend8 = $type3Rend8+$value["Rendement"];
                                                                                            $type3count8 = $type3count8+1;
                                                                            }
                                                                        }
                                                                        
                                                                        
  }
//  //GradeYear3
//  $type1AvgDLE3 = $type1totalDLE3 / $type1count3;
//  $type1AvgDL3 = $type1totalDL3 / $type1count3;
  if(isset($type1Rend3)){$type1Rend3 = $type1Rend3 / $type1count3; }else{$type1Rend3 = 0;}
  if(isset($type2Rend3)){$type2Rend3 = $type2Rend3 / $type2count3; }else{$type2Rend3 = 0;}
  if(isset($type3Rend3)){$type3Rend3 = $type3Rend3 / $type3count3; }else{$type3Rend3 = 0;}
  
   if(isset($type1Rend4)){$type1Rend4 = $type1Rend4 / $type1count4; }else{$type1Rend4 = 0;}
   if(isset($type2Rend4)){$type2Rend4 = $type2Rend4 / $type2count4; }else{$type2Rend4 = 0;}
   if(isset($type3Rend4)){$type3Rend4 = $type3Rend4 / $type3count4; }else{$type3Rend4 = 0;}
  
   if(isset($type1Rend5)){$type1Rend5 = $type1Rend5 / $type1count5; }else{$type1Rend5 =0;}
   if(isset($type2Rend5)){$type2Rend5 = $type2Rend5 / $type2count5; }else{$type2Rend5 =0;}
   if(isset($type3Rend5)){$type3Rend5 = $type3Rend5 / $type3count5; }else{$type3Rend5 =0;}
  
   if(isset($type1Rend6)){$type1Rend6 = $type1Rend6 / $type1count6; }else{$type1Rend6 =0;}
  if(isset($type2Rend6)){$type2Rend6 = $type2Rend6 / $type2count6; }else{$type2Rend6 =0;}
  if(isset($type3Rend6)){$type3Rend6 = $type3Rend6 / $type3count6; }else{$type3Rend6 =0;}
  
   if(isset($type1Rend7)){$type1Rend7 = $type1Rend7 / $type1count7; }else{$type1Rend7 =0;}
  if(isset($type1Rend7)){$type2Rend7 = $type2Rend7 / $type2count7;  }else{$type2Rend7 =0;}
  if(isset($type1Rend7)){$type3Rend7 = $type3Rend7 / $type3count7;  }else{$type3Rend7 =0;}
  
   if(isset($type1Rend8)){$type1Rend8 = $type1Rend8 / $type1count8;  }else{$type1Rend8 =0;}
  if(isset($type2Rend8)){$type2Rend8 = $type2Rend8 / $type2count8;  }else{$type2Rend8 =0;}
  if(isset($type3Rend8)){$type3Rend8 = $type3Rend8 / $type3count8;   }else{$type3Rend8 =0;}
//  $type2AvgDLE3 = $type2totalDLE3 / $type2count3;
//  $type2AvgDL3 = $type2totalDL3 / $type2count3;
//  $type2Rend3 = $type2AvgDLE3 / $type2AvgDL3 * 100;
//  $type3AvgDLE3 = $type3totalDLE3 / $type3count3;
//  $type3AvgDL3 = $type3totalDL3 / $type3count3;
//  $type3Rend3 = $type3AvgDLE3 / $type3AvgDL3 * 100;
// 
//            //GradeYear4
//            $type1AvgDLE4 = $type1totalDLE4 / $type1count4;
//            $type1AvgDL4 = $type1totalDL4 / $type1count4;
//            $type1Rend4 = $type1AvgDLE4 / $type1AvgDL4 * 100;
//            $type2AvgDLE4 = $type2totalDLE4 / $type2count4;
//            $type2AvgDL4 = $type2totalDL4 / $type2count4;
//            $type2Rend4 = $type2AvgDLE4 / $type2AvgDL4 * 100;
//            $type3AvgDLE4 = $type3totalDLE4 / $type3count4;
//            $type3AvgDL4 = $type3totalDL4 / $type3count4;
//            $type3Rend4 = $type3AvgDLE4 / $type3AvgDL4 * 100;
//                
//                    //GradeYear5
//                    $type1AvgDLE5 = $type1totalDLE5 / $type1count5;
//                    $type1AvgDL5 = $type1totalDL5 / $type1count5;
//                    $type1Rend5 = $type1AvgDLE5 / $type1AvgDL5 * 100;
//                    $type2AvgDLE5 = $type2totalDLE5 / $type2count5;
//                    $type2AvgDL5 = $type2totalDL5 / $type2count5;
//                    $type2Rend5 = $type2AvgDLE5 / $type2AvgDL5 * 100;
//                    $type3AvgDLE5 = $type3totalDLE5 / $type3count5;
//                    $type3AvgDL5 = $type3totalDL5 / $type3count5;
//                    $type3Rend5 = $type3AvgDLE5 / $type3AvgDL5 * 100;
//                    
//                                    //GradeYear6
//                                    $type1AvgDLE6 = $type1totalDLE6 / $type1count6;
//                                    $type1AvgDL6 = $type1totalDL6 / $type1count6;
//                                    $type1Rend6 = $type1AvgDLE6 / $type1AvgDL6 * 100;
//                                    $type2AvgDLE6 = $type2totalDLE6 / $type2count6;
//                                    $type2AvgDL6 = $type2totalDL6 / $type2count6;
//                                    $type2Rend6 = $type2AvgDLE6 / $type2AvgDL6 * 100;
//                                    $type3AvgDLE6 = $type3totalDLE6 / $type3count6;
//                                    $type3AvgDL6 = $type3totalDL6 / $type3count6;
//                                    $type3Rend6 = $type3AvgDLE6 / $type3AvgDL6 * 100;
//                                    
//                                                        //GradeYear7
//                                                        $type1AvgDLE7 = $type1totalDLE7 / $type1count7;
//                                                        $type1AvgDL7 = $type1totalDL7 / $type1count7;
//                                                        $type1Rend7 = $type1AvgDLE7 / $type1AvgDL7 * 100;
//                                                        $type2AvgDLE7 = $type2totalDLE7 / $type2count7;
//                                                        $type2AvgDL7 = $type2totalDL7 / $type2count7;
//                                                        $type2Rend7 = $type2AvgDLE7 / $type2AvgDL7 * 100;
//                                                        $type3AvgDLE7 = $type3totalDLE7 / $type3count7;
//                                                        $type3AvgDL7 = $type3totalDL7 / $type3count7;
//                                                        $type3Rend7 = $type3AvgDLE7 / $type3AvgDL7 * 100;
//
//                                                                        //GradeYear8
//                                                                        $type1AvgDLE8 = $type1totalDLE8 / $type1count8;
//                                                                        $type1AvgDL8 = $type1totalDL8 / $type1count8;
//                                                                        $type1Rend8 = $type1AvgDLE8 / $type1AvgDL8 * 100;
//                                                                        $type2AvgDLE8 = $type2totalDLE8 / $type2count8;
//                                                                        $type2AvgDL8 = $type2totalDL8 / $type2count8;
//                                                                        $type2Rend8 = $type2AvgDLE8 / $type2AvgDL8 * 100;
//                                                                        $type3AvgDLE8 = $type3totalDLE8 / $type3count8;
//                                                                        $type3AvgDL8 = $type3totalDL8 / $type3count8;
//                                                                        $type3Rend8 = $type3AvgDLE8 / $type3AvgDL8 * 100;
}else{
    $DLECheck ="false";
}                                                                       
?>
<script>
var DLECheck<?php echo$schoolGraph;?> = <?php echo$DLECheck;?>;
var DLEYear = "Afgelopen 3 jaar";
var DLENorm = <?php echo$norm;?>;
var DLETLW = <?php echo$TLW;?>;
var type1 = "<?php echo$type1;?>";
var type2 = "<?php echo$type2;?>";
var type3 = "<?php echo$type3;?>";


var type1Rend3<?php echo$schoolGraph;?> = <?php echo$type1Rend3;?>;
var type2Rend3<?php echo$schoolGraph;?> = <?php echo$type2Rend3;?>;
var type3Rend3<?php echo$schoolGraph;?> = <?php echo$type3Rend3;?>;

var type1Rend4<?php echo$schoolGraph;?> = <?php echo$type1Rend4;?>;
var type2Rend4<?php echo$schoolGraph;?> = <?php echo$type2Rend4;?>;
var type3Rend4<?php echo$schoolGraph;?> = <?php echo$type3Rend4;?>;

var type1Rend5<?php echo$schoolGraph;?> = <?php echo$type1Rend5;?>;
var type2Rend5<?php echo$schoolGraph;?> = <?php echo$type2Rend5;?>;
var type3Rend5<?php echo$schoolGraph;?> = <?php echo$type3Rend5;?>;

var type1Rend6<?php echo$schoolGraph;?> = <?php echo$type1Rend6;?>;
var type2Rend6<?php echo$schoolGraph;?> = <?php echo$type2Rend6;?>;
var type3Rend6<?php echo$schoolGraph;?> = <?php echo$type3Rend6;?>;

var type1Rend7<?php echo$schoolGraph;?> = <?php echo$type1Rend7;?>;
var type2Rend7<?php echo$schoolGraph;?> = <?php echo$type2Rend7;?>;
var type3Rend7<?php echo$schoolGraph;?> = <?php echo$type3Rend7;?>;

var type1Rend8<?php echo$schoolGraph;?> = <?php echo$type1Rend8;?>;
var type2Rend8<?php echo$schoolGraph;?> = <?php echo$type2Rend8;?>;
var type3Rend8<?php echo$schoolGraph;?> = <?php echo$type3Rend8;?>;
</script>                                                                       
        <?php                                                               
}

//Needs statement for last value in array $i+1;

//calculates the VOData - Tab 5 - Graph 1
// Original plan was to have 2 instances of the data compared to each other so that only the selected students would be retrieved, however it seems to crash the interface when used in phpmyadmin hence it was reformed in php
function VOData($schoolID, $schoolGraph){
      $base = new BaseModel;
      // get the current year and detract 2 to get the desired year from the DB
     $today = date("Y");     
     $year = $today-1;
     $getFunction = "getAdviceVOData";
     $check = $base->showItem($getFunction, $schoolID, $year);
     $getFunction = "getVOData";
     $data = $base->showItem($getFunction, $schoolID, $year);
     $getFunction = "getAdviceLevels";
     $levels = $base->showItem($getFunction);
     $i=0;
     
$month = date("m");
    if($month <= 8){
$year2 = $year."-".$today;        
$year= $today-1;
      
    }else{
        $year2 = $year."-".$today+1;
$year = $today;
        
    
    }  
     //Cleans up the data array allowing only students that match with the ones in 
     foreach($data as $value){
          foreach($check as $value2){
              if($value["studentID"] == $value2["studentID"]){
                 $checkarr = "true";
              }elseif($value["studentID"] != $value2["studentID"]){
                  $checkarr2 = "false";
              }
          }
          if($checkarr2 == "false" && $checkarr != "true"){
              unset($data[$i]);
          }
          unset($checkarr);
          unset($checkarr2);
          $i++;
     }
  
  
 $studentcount=1;
 $dataend = array_values($data);
 $countdata= count($dataend);
  //$studentstartILT = $dataend[0]["ILTLevel"];
  //add a final entry so the last student is also taken into account
  //$dataend[$countdata+1]["studentID"] = 999999999;
  $yearcheck = $dataend[0]["schoolYear"];
  $yearstandard = $today - 5;
  
//  foreach ($dataend as $value){
//      print_r($value);
//      echo "<br /><br />";
//  }
  $p=0;
  for($i=0; $i<=$countdata; $i+1){
      $past = $i-1;
      if($i>=1){
       
          if($dataend[$i]["studentID"] != $dataend[$past]["studentID"]){
               //echo $yearcheck;
               //echo $i."-";
                 if($yearcheck <= $yearstandard){
                    $studentarr[$p]["held"] = "true";
                 }else{
                    $studentarr[$p]["held"] = "false";
                 }
                 $studentarr[$p]["studentID"] = $dataend[$past]["studentID"];
                 $studentILT = $dataend[$past]["adviceLevel"]-$dataend[$past]["ILTLevel"];
                 $studentarr[$p]["ILT"] = $dataend[$past]["ILTLevel"];
                 $studentarr[$p]["adviceLevel"] = $dataend[$past]["adviceLevel"];
                //Opstroom
                 if($studentILT < 0){              
                  $studentarr[$p]["Value"] = "up";
                     //afstroom
                }elseif($studentILT > 0){
                  $studentarr[$p]["Value"] = "down";
                    //gelijk
                }elseif($studentILT == 0){
                  $studentarr[$p]["Value"] = "same";
                }
                $p++;
                $yearcheck = $dataend[$i]["schoolYear"];
                
               
          }else{}
         
  }
    $i++;
  }  //adds all the "opstroom", "afstroom" and "held"         
foreach($studentarr as $value){
    if($value["adviceLevel"] == 1){
        if($value["held"] == "true"){
          $ILT1Held = $ILT1Held+1;
        }
        if($value["Value"] == "up"){
          $ILT1Up = $ILT1Up+1; 
        }elseif($value["Value"] == "down"){
          $ILT1Down = $ILT1Down+1; 
        }elseif($value["Value"] == "same"){
          $ILT1Same = $ILT1Same+1;
        }
    }elseif($value["adviceLevel"] == 1.5){
          if($value["held"] == "true"){
          $ILT2Held = $ILT2Held+1;
        }
        if($value["Value"] == "up"){
          $ILT2Up = $ILT2Up+1; 
        }elseif($value["Value"] == "down"){
          $ILT2Down = $ILT2Down+1; 
        }elseif($value["Value"] == "same"){
          $ILT2Same = $ILT2Same+1;
        }
    }elseif($value["adviceLevel"] == 3){
         if($value["held"] == "true"){
          $ILT3Held = $ILT3+1;
        }
        if($value["Value"] == "up"){
          $ILT3Up = $ILT3Up+1; 
        }elseif($value["Value"] == "down"){
          $ILT3Down = $ILT3Down+1; 
        }elseif($value["Value"] == "same"){
          $ILT3Same = $ILT3Same+1;
        }
    }elseif($value["adviceLevel"] == 4){
         if($value["held"] == "true"){
          $ILT4Held = $ILT4Held+1;
        }
        if($value["Value"] == "up"){
          $ILT4Up = $ILT4Up+1; 
        }elseif($value["Value"] == "down"){
          $ILT4Down = $ILT4Down+1; 
        }elseif($value["Value"] == "same"){
          $ILT4Same = $ILT4Same+1;
        }
    }elseif($value["adviceLevel"] == 5){
         if($value["held"] == "true"){
          $ILT5Held = $ILT5Held+1;
        }
        if($value["Value"] == "up"){
          $ILT5Up = $ILT5Up+1; 
        }elseif($value["Value"] == "down"){
          $ILT5Down = $ILT5Down+1; 
        }elseif($value["Value"] == "same"){
          $ILT5Same = $ILT5Same+1;
        }
    }
    
}             
     $Total1= $ILT1Held + $ILT1Up + $ILT1Down + $ILT1Same;  
      $Total2= $ILT2Held + $ILT2Up + $ILT2Down + $ILT2Same;  
       $Total3= $ILT3Held + $ILT3Up + $ILT3Down + $ILT3Same;  
        $Total4= $ILT4Held + $ILT4Up + $ILT4Down + $ILT4Same;  
         $Total5= $ILT5Held + $ILT5Up + $ILT5Down + $ILT5Same;  
          
         $ILT1HeldPerc = round($ILT1Held / $Total1 * 100, 2);
          $ILT1UpPerc = round($ILT1Up / $Total1 * 100, 2);
           $ILT1DownPerc = round($ILT1Down / $Total1 * 100, 2);
            $ILT1SamePerc = round($ILT1Same / $Total1 * 100, 2);
            
         $ILT2HeldPerc = round($ILT2Held / $Total2 * 100, 2);
          $ILT2UpPerc = round($ILT2Up / $Total2 * 100, 2);
           $ILT2DownPerc = round($ILT2Down / $Total2 * 100, 2);
            $ILT2SamePerc = round($ILT2Same / $Total2 * 100, 2);
         
       $ILT3HeldPerc = round($ILT3Held / $Total3 * 100, 2);
          $ILT3UpPerc = round($ILT3Up / $Total3 * 100, 2);
           $ILT3DownPerc = round($ILT3Down / $Total3 * 100, 2);
            $ILT3SamePerc = round($ILT3Same / $Total3 * 100, 2);
            
         $ILT4HeldPerc = round($ILT4Held / $Total4 * 100, 2);
          $ILT4UpPerc = round($ILT4Up / $Total4 * 100, 2);
           $ILT4DownPerc = round($ILT4Down / $Total4 * 100, 2);
            $ILT4SamePerc = round($ILT4Same / $Total4 * 100, 2);
            
         $ILT5HeldPerc = round($ILT5Held / $Total5 * 100, 2);
          $ILT5UpPerc = round($ILT5Up / $Total5 * 100, 2);
           $ILT5DownPerc = round($ILT5Down / $Total5 * 100, 2);
            $ILT5SamePerc = round($ILT5Same / $Total5 * 100, 2);

         $totalStudents = count($studentarr);
//Checks if there is data to work with.      
if(empty($Total1) && empty($Total2) && empty($Total3) && empty($Total4) && empty($Total5)){
    $VOCheck = "false";
}else{$VOCheck = "true";}   

?>
<script>
    var VOYear<?php echo$schoolGraph;?> = "<?php echo$year2?>";
    var VOCheck<?php echo$schoolGraph;?> = <?php echo$VOCheck;?>;
    var totalVOStudents<?php  echo$schoolGraph." = ";echo$totalStudents;?>;
    var level1 = "<?php echo$levels[0]["educationDescription"];?>";
    var level2 = "<?php echo$levels[1]["educationDescription"];?>";
    var level3 = "<?php echo$levels[2]["educationDescription"];?>";
    var level4 = "<?php echo$levels[3]["educationDescription"];?>";
    var level5 = "<?php echo$levels[4]["educationDescription"];?>";
    
    var ILT1HeldPerc<?php echo$schoolGraph." = ";echo$ILT1HeldPerc;?>;
    var ILT1UpPerc<?php echo$schoolGraph." = ";echo$ILT1UpPerc;?>;
    var ILT1DownPerc<?php echo$schoolGraph." = ";echo$ILT1DownPerc;?>;
    var ILT1SamePerc<?php echo$schoolGraph." = ";echo$ILT1SamePerc;?>;
    
    var ILT2HeldPerc<?php echo$schoolGraph." = ";echo$ILT2HeldPerc;?>;
    var ILT2UpPerc<?php echo$schoolGraph." = ";echo$ILT2UpPerc;?>;
    var ILT2DownPerc<?php echo$schoolGraph." = ";echo$ILT2DownPerc;?>;
    var ILT2SamePerc<?php echo$schoolGraph." = ";echo$ILT2SamePerc;?>;
    
    var ILT3HeldPerc<?php echo$schoolGraph." = ";echo$ILT3HeldPerc;?>;
    var ILT3UpPerc<?php echo$schoolGraph." = ";echo$ILT3UpPerc;?>;
    var ILT3DownPerc<?php echo$schoolGraph." = ";echo$ILT3DownPerc;?>;
    var ILT3SamePerc<?php echo$schoolGraph." = ";echo$ILT3SamePerc;?>;
    
    var ILT4HeldPerc<?php echo$schoolGraph." = ";echo$ILT4HeldPerc;?>;
    var ILT4UpPerc<?php echo$schoolGraph." = ";echo$ILT4UpPerc;?>;
    var ILT4DownPerc<?php echo$schoolGraph." = ";echo$ILT4DownPerc;?>;
    var ILT4SamePerc<?php echo$schoolGraph." = ";echo$ILT4SamePerc;?>;
    
    var ILT5HeldPerc<?php echo$schoolGraph." = ";echo$ILT5HeldPerc;?>;
    var ILT5UpPerc<?php echo$schoolGraph." = ";echo$ILT5UpPerc;?>;
    var ILT5DownPerc<?php echo$schoolGraph." = ";echo$ILT5DownPerc;?>;
    var ILT5SamePerc<?php echo$schoolGraph." = ";echo$ILT5SamePerc;?>;
    </script>
    <?php
            
            
            
      
   
  
  

     
     
}
//Calculates the advice Data - Tab 5 - Graph 2
function adviceVOData($schoolID, $schoolGraph){
     $base = new BaseModel;
      // get the current year and detract 2 to get the desired year from the DB
     $today = date("Y");     
      $month = date("m");
    if($month <= 8){
        $year= $today-1;
       $year2 = $year."-".$today;
    }else{
        $year = $today;
        $year2 = $year."-".$today+1;
    
    } 
     $getFunction = "getAdviceVOData";
     $advice = $base->showItem($getFunction, $schoolID, $year);
     $counter = count($advice);
     $i=0;
     $aantallaag = 0;
     $zwaartelaag =0;
     $aantalgoed = 0;
     $aantalhoog= 0;
     $zwaartehoog =0;
     
      //Checks if the advice is lower, correct or higher and calulates the differences.
     foreach($advice as $value){
         if($advice[$i]["ILTLevel"] < $advice[$i]["adviceLevel"]){
             $aantallaag = $aantallaag + 1;
             $laagdiff = abs($advice[$i]["adviceLevel"] - $advice[$i]["ILTLevel"]);
             $zwaartelaag = $zwaartelaag + $laagdiff;
             $i++;
         }elseif($advice[$i]["ILTLevel"] == $advice[$i]["adviceLevel"]){
             $aantalgoed = $aantalgoed + 1;
             $i++;
         }elseif($advice[$i]["ILTLevel"] > $advice[$i]["adviceLevel"]){
             $aantalhoog = $aantalhoog + 1;
             $hoogdiff= abs($advice[$i]["ILTLevel"] - $advice[$i]["adviceLevel"]);
             $zwaartehoog = $zwaartehoog + $hoogdiff;
             $i++;
         }else{$i++;}
     }
     $hoogafwijking = $zwaartehoog / $aantalhoog;
     $laagafwijking = $zwaartelaag / $aantallaag;
     //echo $counter."<br />".$aantallaag."<br />".$aantalgoed."<br />".$aantalhoog."<br />";
     $hoogafwijking = round($hoogafwijking, 2);
     $laagafwijking = round($laagafwijking, 2);
    // echo $hoogafwijking."<-";
    // echo $laagafwijking."<-";
     ?>
<script>
    var aantallaag<?php echo$schoolGraph;?> = "<?php echo$aantallaag; ?> te laag";
    var aantalgoed<?php echo$schoolGraph;?> = "<?php echo$aantalgoed. " v/d " .$counter; ?> is goed geplaatst";
    var aantalhoog<?php echo$schoolGraph;?> = "<?php echo$aantalhoog; ?> te hoog";
    var laagafwijking<?php echo$schoolGraph;?> = <?php echo$laagafwijking; ?>;
    var hoogafwijking<?php echo$schoolGraph;?> = <?php echo$hoogafwijking; ?>;
    var adviceYear<?php echo$schoolGraph;?> = <?php echo$year;?>;
   </script>

       <?php 
}
//Retrieves the Population and prognosis - Tab 2 - Graph 1
function populationGrowth($schoolID, $schoolGraph){
     $base = new BaseModel;
      // get the current year with modified years to get the desired year from the DB
     $today = date("Y");     
     // 2006-2010 (if $today = 2012)

      $month = date("m");
    if($month <= 8){
       $startTotalYear = $today-5;
       $endTotalYear = $today-1;
       $startProgYear = $today ; 
       $endProgYear = $today + 4;
    }else{
        $startTotalYear = $today-5;
        $endTotalYear = $today-1;
        $startProgYear = $today;
        $endProgYear = $today + 4;
    } 
     

     $getFunction = "getTotalStudentsYearData2";
     $total = $base->showItems($getFunction, $schoolID, $startTotalYear, $endTotalYear);
     $getFunction = "getTotalStudentsPrognosisData";
     $prog = $base->showItems($getFunction, $schoolID, $startProgYear, $endProgYear);
   
     $i=0;
     $p=0;
     $year = $startTotalYear;
        if(isset($prog) && isset($total)){
            $progCheck = "true";
        }else{$progCheck = "false";}
       
       $i=0;
       foreach($total as $value){
           ?> <script>
           var growthTotal<?php echo$schoolGraph;echo$i;echo' = '.$total[$i]["totalStudents"].';' ?>
           var growthTotalYear<?php echo$schoolGraph; echo$i;echo' = '.$total[$i]["year"].';' ?>
           
            </script> <?php
             $i++;
       }
       $i=0;
         foreach($prog as $value){
             ?>
            <script>
           var growthProgTotal<?php echo$schoolGraph;echo$i;echo' = '.$prog[$i]["prognosis"].';' ?>
           var growthProgTotalYear<?php echo$schoolGraph;echo$i;echo' = '.$prog[$i]["prognosisYear"].';' ?>
           </script><?
      
           $i++;
       } ?>
           <script>
               var progCheck<?php echo$schoolGraph;?> = <?php echo$progCheck;?>;
               </script>
         <?php
        
}
//Calculates the CitoScore - Tab 4 - Graph 1
function CitoScore($schoolID, $schoolGraph){
     
      $base = new BaseModel;
      // get the current year and detract 2 to get the desired year from the DB
     $today = date("Y");
      $month = date("m");
    if($month <= 8){
        $year= $today-1;
       $year2 = $today;
    }else{
        $year = $today;
        $year2 = $today+1;
    
    } 
     //$year = $today - 2;
    // $year2 = $today -1;
     $getFunction = "getCitoScore";
     $cito = $base->showItems($getFunction, $schoolID, $year);
     $getFunction ="getCitoStandard";
     $year3 = $year."-".$year2;   
     
     if(isset($cito[0]["totalStudentsWithWeight"])){
          $standard = round($cito[0]["totalStudentsWithWeight"]/$cito[0]["totalStudents"]*100);  
          $citostandard = $base->showItems($getFunction, $standard);
          $citocheck = "true";
     }else{$citocheck = "false";
         $cito[0]["citoDeelname"] = 0;
         $cito[0]["citoScore"] = 0;
         $citostandard[0]["Insp_OnderGrens"] = 0;
         $citostandard[0]["Insp_Gemiddeld"] = 0;
         $citostandard[0]["Insp_BovenGrens"] = 0;
         ;}
     
     
    
     
 ?>
     <script>
         var citoCheck<?php echo$schoolGraph;?> = <?php echo$citocheck;?>;
      var deelname<?php echo$schoolGraph;?> = <?php echo$cito[0]["citoDeelname"];?>;
      var score<?php echo$schoolGraph;?> = <?php echo$cito[0]["citoScore"];?>;
      var onderGrens<?php echo$schoolGraph;?> = <?php echo$citostandard[0]["Insp_OnderGrens"];?>;
      var gem<?php echo$schoolGraph;?> = <?php echo$citostandard[0]["Insp_Gemiddeld"];?>;
      var bovenGrens<?php echo$schoolGraph;?> = <?php echo$citostandard[0]["Insp_BovenGrens"];?>;
      var citojaar<?php echo$schoolGraph;?> = "<?php echo$year3;?>";
      
     </script>
   <?php         
}

}
?>
