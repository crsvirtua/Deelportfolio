<?php

class BaseModel {
    //function used to show an item, able to show multiple items, getFunction needs to be the name of the query.
   function showItem($getFunction, $id, $id2, $id3) {
        
        $contentthroughput = new queryManager;
       
        $content = $contentthroughput->$getFunction($id, $id2, $id3);

        return $content;
        
    }
    //pfunction used to show multiple items, getFunction needs to be the name of the query. Mainly used for clarity in the code so programmers know there are multiple items
    function showItems($getFunction, $id, $id2, $id3) {
        
        $contentthroughput = new queryManager;
        $content = $contentthroughput->$getFunction($id, $id2, $id3);

        return $content;
        
    }
   //Function used to add an item addFunction being the name of the query
    function addItem($addFunction, $formValues) {
        $contentthroughput = new queryManager;
        $content = $contentthroughput->$addFunction($formValues);
        return $content;
    }
   //Function used to edit an item, editFunction being the name of the query
    function editItem($editFunction, $formValues, $uname) {
        
        $contentthroughput = new queryManager;
        $content = $contentthroughput->$editFunction($formValues, $uname);

        return $content;
        
    }
    //Function used to edit an item, GetFunction being the name of the query
    function delItem($getFunction, $id) {
        $contentthroughput = new queryManager;
        $content = $contentthroughput->$getFunction($id);

        return $content;
    }
    //Generates an random string for security functions
    function generateRandString($length) {

    $availableChars = "abcdefghijklmopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $availableNumbers = "0123456789";
    $currentTime = time();
    $randomSeed = rand((($availableNumbers*$currentTime)*$currentTime)/102030);

        for($i = 0; $i < $length; $i++) {

            $str = substr( str_shuffle( $availableChars . $availableNumbers ), $randomSeed, $length );

        }

        return $str;

    }
    
}
?>