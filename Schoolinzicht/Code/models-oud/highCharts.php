<?php 

require_once MODEL_BASEMODEL;

//change this one once it has been added:


require_once INCLUDE_QUERYMANAGER;
require_once MODEL_TAB;
require_once MODEL_CHARTCOMPONENT;
?>

<?php



Class highCharts extends baseModel {
    
    
    /*Main function for making a graph. Call this graph with parameters to create graph.
     * $SwitchID = Profile/Comparison
     * $tabID = the ID of the tab in question
     * $schoolID = BRIN
     * $schoolGraph = 1, 2 or 3 depending on how many you want.
     */ 
    function generateGraph ($switchID, $tabID, $schoolID, $schoolGraph){
        $tab = new tab;
        //  $tab->globalCalc($tabID, $schoolID);  
     //print_r($content);
         // echo $switchID.$tabID.$schoolID;
         // 
         // 
       //Define the variables used for the graphs    
        
        if($tabID == 1){
            if($switchID == 'profile'){
               
             $area =  $tab->areaCalc($schoolID, $schoolGraph);
           
            echo  '<div id="profileschoolgraph1big" id="profileschoolgraph1"></div>'; 

            echo '<script>'; 
            echo 'if(noGraph==false){'; 
            echo 'var graphValues=new Array();';
                         for($i = 1; $i<=6; $i++){
                             $arraycount = $i-1;
                             echo "graphValues[$arraycount] = transitionValues[$arraycount] /total *100;";           
                         }
           //Call the graph function
            echo 'createChartProfile1()'; 
            echo '}else{createUnavailableProfile1() ;      
                               } ';   
            echo '</script>';
            
            }elseif($switchID == 'schoolupdate') {
                $area =  $tab->areaCalc($schoolID);
                echo  '<div id="profileschoolgraph1big" id="profileschoolgraph1"></div>'; 
                echo '<script>'; 
                echo 'if(noGraph==false){'; 
                echo 'var graphValues=new Array();';
                            for($i = 1; $i<=6; $i++){
                                $arraycount = $i-1;
                                echo "graphValues[$arraycount] = transitionValues[$arraycount] /total *100;";           
                            }
            //Call the graph function
                echo 'createChartProfile1()'; 
                echo '}else{createUnavailableProfile1() ;      
                                } ';   
                echo '</script>';
            }elseif($switchID == 'comparison'){
                $area =  $tab->areaCalc($schoolID, $schoolGraph);  
                   echo  '<div id="compareschoolgraph'.$schoolGraph.'big" id="compareschoolgraph'.$schoolGraph.'"></div>'; 
                   //Defining all variables for this tab
                //Call the graph function
                    if($schoolGraph == 1 ){
                           echo '<script>'; 
                           
                         echo 'if(noGraph==false){'; 
                    //Due to the highcharts not being able to handle arrays and variables that have been put directly into a javascript
                    // variable from PHP, we've decided to do part of the calculation in javascript for now. 
                       
                               //fills the JS variables names with the right value from the JS array
                         for($i = 1; $i<=6; $i++){
                            $arraycount = $i-1;
                             echo "var name$schoolGraph$i = transitionKeys[$arraycount];";
                             
                         }
                         //fills the JS variables percentages with the right value from the JS array
                          for($i = 1; $i<=6; $i++){
                             $arraycount = $i-1;
                             echo "var percentages$schoolGraph$i = transitionValues[$arraycount] /total *100;";
                             
                         }     
                      echo 'var total1 = total;';           
                      echo 'createChartComparison11()';
                      echo '}else{createUnavailable1() ;      
                               } ';                             
                              echo '</script>';
                    }
                    elseif($schoolGraph == 2 ){
                            echo '<script>';                      
               
                         echo 'if(noGraph==false){'; 
                    //Due to the highcharts not being able to handle arrays and variables that have been put directly into a javascript
                    // variable from PHP, we've decided to do part of the calculation in javascript for now. 
                       
                               //fills the JS variables names with the right value from the JS array
                         for($i = 1; $i<=6; $i++){
                            $arraycount = $i-1;
                             echo "var name$schoolGraph$i = transitionKeys[$arraycount];";                            
                         }
                         //fills the JS variables percentages with the right value from the JS array
                          for($i = 1; $i<=6; $i++){
                             $arraycount = $i-1;
                             echo "var percentages$schoolGraph$i = transitionValues[$arraycount] /total *100;";                           
                         }
                    echo 'var total2 = total;';
                   
                        echo 'createChartComparison12()'; 
                               echo '}else{createUnavailable2() ;   
                               } '; 
                             echo '</script>';   
                    }
                    elseif($schoolGraph == 3){
                             echo '<script>'; 
                        
                         echo 'if(noGraph==false){'; 
                    //Due to the highcharts not being able to handle arrays and variables that have been put directly into a javascript
                    // variable from PHP, we've decided to do part of the calculation in javascript for now. 
                       
                               //fills the JS variables names with the right value from the JS array
                         for($i = 1; $i<=6; $i++){
                            $arraycount = $i-1;
                             echo "var name$schoolGraph$i = transitionKeys[$arraycount];"; 
                         }
                         //fills the JS variables percentages with the right value from the JS array
                          for($i = 1; $i<=6; $i++){
                             $arraycount = $i-1;
                             echo "var percentages$schoolGraph$i = transitionValues[$arraycount] /total *100;";    
                         }
                      echo 'var total3 = total;';
                        echo 'createChartComparison13()'; 
                         echo '}else{createUnavailable3() ;
                                 
                               } '; 
                             echo '</script>';
                    }
            }
        }elseif($tabID == 2){
              
            if($switchID == 'profile'){
                //echo $schoolGraph;
               $call = $tab->populationGrowth($schoolID, $schoolGraph);
                
                echo  '<div id="profileschoolgraph1big" id="profileschoolgraph1"></div>'; 
                ?>
                <script>
                    if(progCheck1 == true){
                        createChartProfile2();
                    }else{createProfileUnavailable1();}
                    </script>
                    <?php
            }elseif($switchID == 'schoolupdate'){
                $call = $tab->populationGrowth($schoolID, $schoolGraph);
                echo  '<div id="profileschoolgraph2big" id="profileschoolgraph2"></div>'; 
                ?>
                   <script>
                    if(progCheck1 == true){
                        createChartSchoolupdate2()
                    }else{createSchoolUnavailable2();}
                    </script><?php
            }elseif($switchID == 'comparison'){
                       $call = $tab->populationGrowth($schoolID, $schoolGraph);
                    echo  '<div id="compareschoolgraph'.$schoolGraph.'big" id="compareschoolgraph'.$schoolGraph.'"></div>'; 
                    if($schoolGraph == 1){
                         echo '<script>';
                         echo 'if(progCheck1== true){';
                          echo 'createChartComparison21()';
                          echo '}else{createUnavailable1()}';
                           echo '</script>';
                    }
                    if($schoolGraph == 2){
                         echo '<script>';
                          echo 'if(progCheck2== true){';
                          echo 'createChartComparison22()';
                           echo '}else{createUnavailable2()}';
                           echo '</script>';
                    }
                    if($schoolGraph == 3){
                         echo '<script>';
                         echo 'if(progCheck3== true){';
                          echo 'createChartComparison23()';
                           echo '}else{createUnavailable3()}';
                           echo '</script>';
                    }
            }
        }elseif($tabID == 3){
            if($switchID == 'profile'){
                $call = $tab->getDLE($schoolID, $schoolGraph);
                echo  '<div id="profileschoolgraph1big" id="profileschoolgraph1big"></div>'; 
                ?>
                    <script>
                        if(DLECheck1 == true){
                        createChartProfile3();
                        }else{createProfileUnavailable1();}
                  
                    </script>
                <?php
            }elseif($switchID == 'schoolupdate'){
                $call = $tab->getDLE($schoolID, $schoolGraph);
                echo  '<div id="profileschoolgraph3big" id="profileschoolgraph3big"></div>'; 
                 ?>
                   <script>
                    if(DLECheck1 == true){
                        createChartSchoolupdate3()
                    }else{createSchoolUnavailable3();}
                    </script><?php
            }elseif($switchID == 'comparison'){
                 $call = $tab->getDLE($schoolID, $schoolGraph);
                 echo  '<div id="compareschoolgraph'.$schoolGraph.'big" id="compareschoolgraph'.$schoolGraph.'"></div>'; 
                    if($schoolGraph == 1){
                         echo '<script>';
                         echo 'if(DLECheck1== true){';
                          echo 'createChartComparison31()';
                          echo '}else{createUnavailable1()}';
                           echo '</script>';
                    }
                    if($schoolGraph == 2){
                         echo '<script>';
                          echo 'if(DLECheck2== true){';
                          echo 'createChartComparison32()';
                           echo '}else{createUnavailable2()}';
                           echo '</script>';
                    }
                    if($schoolGraph == 3){
                         echo '<script>';
                         echo 'if(DLECheck3== true){';
                          echo 'createChartComparison33()';
                           echo '}else{createUnavailable3()}';
                           echo '</script>';
                    }
            }
        }elseif($tabID == 4){
            
             if($switchID == 'profile'){ 
                $call = $tab->CitoScore($schoolID, $schoolGraph);
                echo  '<div id="profileschoolgraph1big" id="profileschoolgraph1big"></div>'; 
                 ?>
                    <script>
                    if(citoCheck1 == true){
                        createChartProfile4();
                    }else{createProfileUnavailable1();}
                    </script>
                <?php
               
            }elseif($switchID == 'schoolupdate'){    
                $call = $tab->CitoScore($schoolID, $schoolGraph);
                echo  '<div id="profileschoolgraph4big" id="profileschoolgraph4big"></div>'; 
                ?>
                   <script>
                    if(citoCheck1 == true){
                        createChartSchoolupdate4()
                    }else{createSchoolUnavailable4();}
                    </script><?php
            }elseif($switchID == 'comparison'){  
                $call = $tab->CitoScore($schoolID, $schoolGraph);
                    echo  '<div id="compareschoolgraph'.$schoolGraph.'big" id="compareschoolgraph'.$schoolGraph.'"></div>'; 
                    if($schoolGraph == 1){
                         echo '<script>';
                         echo 'if(citoCheck1== true){';
                          echo 'createChartComparison41()';
                         echo'}else{createUnavailable1() }';
                           echo '</script>';
                    }
                    if($schoolGraph == 2){
                         echo '<script>';
                          echo 'if(citoCheck2== true){';
                          echo 'createChartComparison42()';
                            echo'}else{createUnavailable2()}';
                           echo '</script>';
                    }
                    if($schoolGraph == 3){
                         echo '<script>';
                          echo 'if(citoCheck3== true){';
                          echo 'createChartComparison43()';
                            echo'}else{createUnavailable3()}';
                           echo '</script>';
                    }
            }
           
            
             
        }elseif($tabID == 5){
            if($switchID == 'profile'){
                $advice = $tab->adviceVOData($schoolID, $schoolGraph);
                $VO = $tab->VOData($schoolID, $schoolGraph);     
                echo  '<div id="profileschoolgraph1bigVO" id="profileschoolgraph1bigVO"></div>'; 
                echo  '<div id="profileschoolgraph1bigadvice" id="profileschoolgraph1bigadvice"></div>'; 
                ?>
                     <script>
                    if(VOCheck1== true){
                        createChartProfile51();
                        createChartProfile52();
                    }else{createProfileUnavailable2();}
                    </script>
                <?php
          //      echo '<script>'; 
            //    echo 'createChartProfile51()';
              //  echo '</script>';
               // echo '<script>'; 
                //echo 'createChartProfile52()';
               // echo '</script>';
            }elseif($switchID == 'schoolupdate'){
                $advice = $tab->adviceVOData($schoolID, $schoolGraph);
                $VO = $tab->VOData($schoolID, $schoolGraph);     
                echo  '<div id="profileschoolgraph5bigVO" id="profileschoolgraph5bigVO"></div>'; 
                echo  '<div id="profileschoolgraph5bigAdvice" id="profileschoolgraph5bigAdvice"></div>'; 
                 ?>
                     <script>
                    if(VOCheck1== true){
                        createChartSchoolupdate51();
                        createChartSchoolupdate52();
                    }else{createSchoolUnavailable5();}
                    </script>
                <?php
            }elseif($switchID == 'comparison'){
                $advice = $tab->adviceVOData($schoolID, $schoolGraph);
                $VO = $tab->VOData($schoolID, $schoolGraph);    
              echo  '<div id="compareschoolgraph'.$schoolGraph.'big" id="compareschoolgraph'.$schoolGraph.'"></div>'; 
                    if($schoolGraph == 1){
                         echo '<script>';
                         echo 'if(VOCheck1== true){';
                          echo 'createChartComparison511()';
                         echo'}else{createUnavailable1() }';
                           echo '</script>';
                    }
                    if($schoolGraph == 2){
                         echo '<script>';
                          echo 'if(VOCheck2== true){';
                         echo 'createChartComparison512()';
                            echo'}else{createUnavailable2()}';
                           echo '</script>';
                    }
                    if($schoolGraph == 3){
                         echo '<script>';
                          echo 'if(VOCheck3== true){';
                       echo 'createChartComparison513()';
                            echo'}else{createUnavailable3()}';
                           echo '</script>';
                    }
            }
           
             
        }elseif($tabID == 6){
             
             $inspection = $tab->inspectionResults($schoolID);
             echo  '<div id="'.$switchID.'schooldata>';
             echo  '<div id="'.$switchID.'schooldata>';
                      
             if($inspection == "empty"){
                  echo '<div class="schoolinspection">Inspectie gegevens zijn helaas niet beschikbaar voor deze school op dit moment.</div>';
                  echo '</div>';   
             }else{
                echo '<div class="schoolinspection"><b>Oordeel:</b>'.$inspection[0]["resultDescription"].'</div>';
                  echo '<div class="schoolinspection"><b>Link naar het rapport:</b><a href="'.$inspection[0]["inspectionURL"].'">Klik hier</a></div>';     
                  echo '</div>';   
             } 
        }elseif($tabID == 7){
           echo  '<div id="'.$switchID.'schooldata">'; 
                 
                      $business =  $tab->businessData($schoolID);
                 
                     if($business == "empty"){
                         echo '<div class="schoolinspection">Bedrijfskundige informatie is helaas niet beschikbaar voor deze school op dit moment.</div>';
                         echo '</div>';
                     }else{
                     echo '<div class="schoolbusiness1"><b>Personeel:</b></div>';
                     echo '<div class="schoolbusiness1"><b>Directieleden:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</b>'.$business[0]["directieleden"].'&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</div>';
                     echo '<div class="schoolbusiness1"><b>Onderwijzend:</b>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp'.$business[0]["onderwijzendPersoneel"].'&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</div>';
                     echo '<div class="schoolbusiness1"><b>Onderwijs ondersteunend:</b>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp'.$business[0]["onderwijsOndersteunendPersoneel"].'&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</div>';
                     echo '<div class="schoolbusiness1"><b>Mannen:</b>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp'.$business[0]["mannen"].'&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</div>';
                     echo '<div class="schoolbusiness1"><b>Vrouwen:</b>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp'.$business[0]["vrouwen"].'&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</div>';
                     echo '<div class="schoolbusiness1"><b>Totaal:</b>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp'.$business[0]["totalPers"].'&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</div>';
                    
                     echo '</div>';
                      echo  '<div id="'.$switchID.'schooldata">'; 
                     echo '<div class="schoolbusiness1"><b>FTE:</b></div>';
                     echo '<div class="schoolbusiness1"><b></b>'.$business[0]["directieledenFTE"].'&nbsp&nbsp</div>';
                     echo '<div class="schoolbusiness1"><b></b>'.$business[0]["onderwijzendPersoneelFTE"].'&nbsp&nbsp</div>';
                     echo '<div class="schoolbusiness1"><b></b>'.$business[0]["onderwijsOndersteunendPersoneelFTE"].'&nbsp&nbsp</div>';
                     echo '<div class="schoolbusiness1"><b></b>'.$business[0]["mannenFTE"].'&nbsp&nbsp</div>';
                     echo '<div class="schoolbusiness1"><b></b>'.$business[0]["vrouwenFTE"].'&nbsp&nbsp</div>';
                     echo '<div class="schoolbusiness1"><b></b>'.$business[0]["totalFTE"].'&nbsp&nbsp</div>';
                        echo '</div>';
                     
                     }
        }
    }

}

?>
