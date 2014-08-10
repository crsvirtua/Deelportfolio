<?php


class dbManager {
    
    public function openConnection() {  
        $host = "localhost";
        $user = "system";
        $password ="JhcAsg#01";
        $name = "audit";
        $this->connection = mysql_connect ($host, $user, $password, $name) or die(mysql_error());
        $this->database = mysql_select_db($name) or die(mysql_error());
    }
    
    public function closeConnection() {
        //clean up the connection:
        $this->connection = mysql_close();
        return TRUE;
    }
    
    public function executeQuery($query) {
        //update table(s) in db
        //execute the update/delete/alter query
        //and return TRUE
        $this->query = $query;
        
        mysql_query($this->query) or die(mysql_error());
        
        return "query was successful";
    }
    
    public function doQuery($query) {
        $this->query = $query;
        //fetch result from table(s) in db 
        //store query results in variable 'result'
        //and return TRUE
            $this->result = mysql_query($this->query) or die(mysql_error());
    }
    
    public function fetch()
    {   $nums = mysql_num_rows($this->result);
        while($i < $nums) {
            $row[] = mysql_fetch_assoc($this->result);
            $i++;
        }
        return $row;
    }
    public function createCSV($auditID, $auditNaam) {
        
        $dbManager = new dbManager;
        $connection = $dbManager->openConnection();
        
        $select = "SELECT score.Score_ID, audit.AuditNaam, auditoren.Naam, rol.Rol, kenmerken.Kenmerk, 
                   indicatoren.Indicator, score.Score, score.Toelichting
                   FROM score
                   INNER JOIN audit ON audit.Audit_ID = score.Audit_ID
                   INNER JOIN auditoren ON auditoren.Pers_ID = score.Auditor_ID
                   INNER JOIN indicatoren ON indicatoren.Indicator_ID = score.Indicator_ID
                   INNER JOIN kenmerken ON kenmerken.Kenmerk_ID = indicatoren.Kenmerk_ID
                   INNER JOIN rol ON rol.Rol_ID = auditoren.Rol_ID
                   WHERE score.Audit_ID = '$auditID'";
                   

        $export = mysql_query ( $select ) or die ( "Sql error : " . mysql_error( ) );

        $fields = mysql_num_fields ( $export );

        for ( $i = 0; $i < $fields; $i++ )
        {
            $header .= mysql_field_name( $export , $i ) . "\t";
        }

        while( $row = mysql_fetch_row( $export ) )
        {
            $line = '';
            foreach( $row as $value )
            {                                            
                if ( ( !isset( $value ) ) || ( $value == "" ) )
                {
                    $value = "\t";
                }
                else
                {
                    $value = str_replace( '"' , '""' , $value );
                    $value = '"' . $value . '"' . "\t";
                }
                $line .= $value;
            }
            $data .= trim( $line ) . "\n";
        }
        $data = str_replace( "\r" , "" , $data );

        if ( $data == "" )
        {
            $data = "\n(0) Records Found!\n";                        
        }

        header("Content-type: application/octet-stream");
        header("Content-Disposition: attachment; filename=scores_".$auditNaam."_".date('d-m-Y').".xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        print "$header\n$data";
    }
}

?>