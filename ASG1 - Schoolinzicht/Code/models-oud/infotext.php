<?php

//Designed and written in the year 2012, for ASG, by:
//Peter van Kleef, Richard Floris & Pepijn de Vries.

require_once MODEL_BASEMODEL;
require_once INCLUDE_QUERYMANAGER;

Class Infotext extends baseModel{
  //Gets the info content for the infotext component 
  function getInfo($pageName) {
      $getInfo = new queryManager;
      $content = $getInfo->getPageInfotext($pageName);
      return $content;
  }
}
?>
