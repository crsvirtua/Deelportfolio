<?php

//Designed and written in the year 2012, for ASG, by:
//Peter van Kleef, Richard Floris & Pepijn de Vries.

require_once MODEL_BASEMODEL;
require_once INCLUDE_QUERYMANAGER;

class menu extends BaseModel {
    //not necessary function, used for testing should be used with showItem
    function getMenu() {
        
        $contentthroughput = new queryManager;
        $content = $contentthroughput->getMenu();

        return $content;
     
    }
    
}
?>