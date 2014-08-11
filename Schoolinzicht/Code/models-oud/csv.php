<?php

require_once MODEL_BASEMODEL;
require_once INCLUDE_CSVQUERYMANAGER;

//Designed and written in the year 2012, for ASG, by:
//Peter van Kleef, Richard Floris & Pepijn de Vries.

 class CSV extends BaseModel{
  
    //Import function selected server filepath
    function import($postArray){
        foreach($postArray as $value) {
            $name = $value;
            $path = INCLUDES_PATH.'CSV/';
            $pathName = $path.$name.'.csv';
            
            $test = new CSVqueryManager;
            $test2 = $test->$name($pathName);
            
            //put the .csv file in anoter folder called 'used':            
            //add a the current date to the .csv so it will be recognizable:
            $DEST = INCLUDES_PATH.'CSV/used/'.$name.'___'.date("d_m_Y__His").'.csv';
            copy($pathName, $DEST);
            unlink($pathName);
            
        }
      return "done";
    }
    
    function checkExisting() {
        //set the path and scan for files in that folder:
        $path = INCLUDES_PATH.'CSV/';
        $files = scandir($path);
        
        //remove the parent directories from the results:
        unset($files[0]);
        unset($files[1]);
        
        //put the remaining parts into a new array (starting with the 0):
        //also remove the '.csv' from each value:
        $i =0;
        foreach($files as $value) {
            if(strpos($value,'used') !== false) {
                unset($files[$i]);
            }
            else {
                $pieces = explode(".", $value);
                $value = $pieces[0];
                $fileArray[$i]['name'] = $value;
                $fileArray[$i]['size'] = filesize($path.$value.'.csv');
                
            }
                $i++;
        }
        //send the names of all the files back to the view:
        return $fileArray;
    }
    function checkDone() {
        //set the path and scan for files in that folder:
        $path = INCLUDES_PATH.'CSV/used/';
        $files = scandir($path);
        
        //remove the parent directories from the results:
        unset($files[0]);
        unset($files[1]);
        
        //put the remaining parts into a new array (starting with the 0):
        //also remove the '.csv' from each value:
        $i =0;
        foreach($files as $value) {
            if(strpos($value,'used') !== false) {
                unset($files[$i]);
            }
            else {
                $pieces = explode(".", $value);
                $value = $pieces[0];
                $fileArray[$i]['nameLong'] = $value;
                $nameparts = explode("___", $value);
                $name = $nameparts[0];
                $fileArray[$i]['size'] = filesize($path.$value.'.csv');
                $fileArray[$i]['date'] = date("d/m/Y H:i:s", filemtime($path.$value.'.csv'));
                $fileArray[$i]['name'] = $name;
            }
                $i++;
        }
        //send the names of all the files back to the view:
        return $fileArray;
    }
 }
?>
