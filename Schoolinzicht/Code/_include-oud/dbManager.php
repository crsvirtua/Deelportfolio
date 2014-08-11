<?php

//Designed and written in the year 2012, for ASG, by:
//Peter van Kleef, Richard Floris & Pepijn de Vries.


include_once INCLUDES_PATH.'bootstrap.php';

//this file contains the basic functions needed to open, close and use a connection
//to the database

class dbManager {
    
    //start a connection with the database:
    public function openConnection() {        
        $this->connection = mysql_connect (DBHost, DBUser, DBPassword, DBName) or die(mysql_error());
        $this->database = mysql_select_db(DBName) or die();
    }
    
    //close a connection with the database:
    public function closeConnection() {
        //clean up the connection:
        $this->connection = mysql_close();
        return TRUE;
    }
    
    //executeQuery to execute (update/change):
    public function executeQuery($query) {
        //update table(s) in db
        //execute the update/delete/alter query
        //and return TRUE
        $this->query = $query;
        
        mysql_query($this->query) or die(mysql_error());
        
        return "query was successful";
    }
    
    //retreive data from database (get):
    public function doQuery($query) {
        $this->query = $query;
        //fetch result from table(s) in db 
        //store query results in variable 'result'
        //and return TRUE
            $this->result = mysql_query($this->query) or die(mysql_error());
    }
    
    //fetch function:
    public function fetch()
    {   $nums = mysql_num_rows($this->result);
        while($i < $nums) {
            $row[] = mysql_fetch_assoc($this->result);
            $i++;
        }
        return $row;
    }
    
}

?>