<?php
require_once("dbManager.php");

//Designed and written in the year 2012, for ASG, by:
//Peter van Kleef, Richard Floris & Pepijn de Vries.


class queryManager extends dbManager {
    
    //The actual function that every queryFunction uses,
    //this function calls for functions in the dbManager:
    function handleQuery($query) {
        $this->manager = new dbManager();
        $this->manager->openConnection();
        $this->manager->doQuery($query);
        $content = $this->manager->fetch();
        $this->manager->closeConnection(); 
        
        return $content;
    }
    
    //the actual function that every updateFunction uses,
    //this function calls for functions in the dbManager:    
    function writeQuery($query) {
        $this->manager = new dbManager();
        $this->manager->openConnection();
        $this->manager->executeQuery($query);
        $this->manager->closeConnection(); 
    }
    function getAudit($auditID){
        $query = "SELECT AuditNaam, AuditSchool, AuditDoel
                 FROM audit
                 WHERE Audit_ID = '$auditID'";
        
        $content = $this->handleQuery($query);
        
        return $content;    
    }
    function getAuditor2($naam) {
        $query = "SELECT auditoren.Pers_ID FROM auditoren WHERE Naam='$naam'";
                
        $content = $this->handleQuery($query);
        
        return $content;    
    }
    function getAuditor($auditorID) {
        $query = "SELECT auditoren.Naam, rol.Rol, audittype.AuditType
                 FROM auditoren
                 INNER JOIN rol ON rol.Rol_ID = auditoren.Rol_ID
                 INNER JOIN audittype ON audittype.AuditType_ID = auditoren.AuditType_ID
                 WHERE Pers_ID = '$auditorID'";
        
        $content = $this->handleQuery($query);
        
        return $content;    
    }
    function getAudits(){
        $query = "SELECT * FROM audit";
     
        $content = $this->handleQuery($query);
        
        return $content;    
    }
    function setBijlage($auditID, $naam, $path, $comment){
         $query = "INSERT INTO bijlage (Audit_ID, Bijlage_Naam, Bijlage_Path, Bijlage_Comment) VALUES('$auditID', '$naam', '$path', '$comment')";
        
        $content = $this->writeQuery($query);
        
        return $content;
    }
    function getBijlage($auditID){
        $query = "SELECT * FROM bijlage WHERE Audit_ID = '$auditID'";
        $content = $this->handleQuery($query);
        return $content;
    }
    function removeBijlage($auditID, $bijlage){
         $query = "DELETE FROM bijlage WHERE Audit_ID='$auditID' AND Bijlage_ID= '$bijlage'"; 
        $content = $this->writeQuery($query);
        return $content;
    }
         
    function getKenmerken(){
        $query = "Select Kenmerk_ID, Kenmerk FROM kenmerken";
     
        $content = $this->handleQuery($query);
        
        return $content;    
    }
    function getKenmerkenType($auditID, $type){
        $query = "Select Kenmerk_ID, Kenmerk FROM kenmerken";
     
        $content = $this->handleQuery($query);
        
        return $content;    
    }
    function getKenmerkSamenvattingType($auditID, $kenmerkID, $type){
        $query = "SELECT * FROM samenvatting 
            INNER JOIN indicatoren ON indicatoren.Kenmerk_ID = samenvatting.Kenmerk_ID INNER JOIN score ON score.Indicator_ID = indicatoren.Indicator_ID
            INNER JOIN auditoren ON auditoren.Pers_ID = samenvatting.Auditor_ID
            WHERE samenvatting.Audit_ID ='$auditID' AND samenvatting.Kenmerk_ID='$kenmerkID' AND samenvatting.Audittype ='$type'";
     
        $content = $this->handleQuery($query);
        
        return $content;    
    }
     function getDatum($auditID, $auditorID){
        $query = "SELECT * FROM datum
            WHERE Audit_ID ='$auditID' AND Pers_ID='$auditorID'";
     
        $content = $this->handleQuery($query);
        
        return $content;    
    }
    function setDatum($auditID, $auditorID, $datum){
         $query = "INSERT INTO datum (Audit_ID, Pers_ID, DatumAfname) VALUES('$auditID', '$auditorID', '$datum')";
        
        $content = $this->writeQuery($query);
        
        return $content;
    }
    function getKenmerkSamenvatting($auditID, $auditorID, $type){
        $query = "Select * FROM samenvatting WHERE Audit_ID= '$auditID' AND Auditor_ID = '$auditorID' AND Audittype = '$type'";
        
        $content = $this->handleQuery($query);
        
        return $content;    
    }
   
    function updateKenmerkSamenvatting($auditID, $auditorID, $kenmerkID, $samenvatting, $type){
        $query="UPDATE samenvatting 
                 SET Samenvatting='$samenvatting'
                 WHERE Audit_ID='$auditID' AND Auditor_ID='$auditorID' AND Kenmerk_ID='$kenmerkID' AND Audittype='$type'";
   $content = $this->writeQuery($query);
        
        return $content;
        }
        
    function setKenmerkSamenvatting($auditID, $auditorID, $kenmerkID, $samenvatting, $type){
         $query = "INSERT INTO samenvatting (Audit_ID, Auditor_ID, Kenmerk_ID, Samenvatting, Audittype) VALUES('$auditID', '$auditorID', '$kenmerkID', '$samenvatting', '$type')";
        
        $content = $this->writeQuery($query);
        
        return $content;
    }
    function getConclusions($auditID, $type){
         $query = "SELECT conclusie.Conclusie FROM conclusie
               
                   WHERE conclusie.Audit_ID = '$auditID' AND conclusie.Audittype ='$type'";
        
        $content = $this->handleQuery($query);
        
        return $content;    
    }
     function getConclusionsType($auditID, $type){
         $query = "SELECT conclusie.Conclusie FROM conclusie
               
                   WHERE conclusie.Audit_ID = '$auditID' AND conclusie.Audittype ='$type'";
        
        $content = $this->handleQuery($query);
        
        return $content;    
    }
    function setConclusion($auditID, $conclusie, $type){
        $query = "INSERT INTO conclusie (Audit_ID, Conclusie, Audittype) VALUES ('$auditID', '$conclusie', '$type')";
        
        $content = $this->writeQuery($query);
    }
    function updateConclusion($auditID, $conclusie, $type){
        $query = "UPDATE conclusie
                  SET Conclusie='$conclusie'
                  WHERE Audit_ID='$auditID' AND Audittype='$type'";
                
        $content = $this->writeQuery($query);
    }
    function checkType($auditID, $auditorID){
          $query = "SELECT score.Audittype FROM score
               
                   WHERE score.Audit_ID = '$auditID' AND score.Auditor_ID ='$auditorID'";
        
        $content = $this->handleQuery($query);
        
        return $content;    
    }
    function getNotes($auditID){
         $query = "Select * FROM extra WHERE Audit_ID = '$auditID'";
        
        $content = $this->handleQuery($query);
        
        return $content;    
    }
    function getKenmerkSamenvattingen($auditID, $kenmerkID){
        $query = "Select * FROM samenvatting WHERE Audit_ID = '$auditID' AND Kenmerk_ID ='$kenmerkID'";
     
        $content = $this->handleQuery($query);
        
        return $content; 
    }
    function getRapportOpmerkingen($auditID, $type){
        
       $query = "SELECT auditoren.Naam, score.Indicator_ID, indicatoren.Indicator, score.Toelichting
                FROM score
                INNER JOIN auditoren ON auditoren.Pers_ID = score.Auditor_ID 
                INNER JOIN rol ON rol.Rol_ID = auditoren.Rol_ID
                INNER JOIN indicatoren ON indicatoren.Indicator_ID = score.Indicator_ID
                WHERE score.Audit_ID = '$auditID'
                AND score.Audittype = '$type'
                AND score.Toelichting IS NOT NULL
        ORDER BY score.Indicator_ID";
         $content = $this->handleQuery($query);
        
        return $content;
    }
    

    function getAuditors(){
        $query = "SELECT auditoren.Pers_ID, auditoren.Naam, auditoren.Rol_ID, rol.Rol, auditoren.AuditType_ID FROM auditoren
                  INNER JOIN rol ON rol.Rol_ID = auditoren.Rol_ID";
     
        $content = $this->handleQuery($query);
        
        return $content;    
    }
    function getScoredAuditors($auditID, $type){
        $query = 
        "SELECT  auditoren.Pers_ID, auditoren.Naam, auditoren.Rol_ID, rol.Rol FROM score
            INNER JOIN auditoren on auditoren.Pers_ID = score.Auditor_ID
            INNER JOIN rol on rol.Rol_ID = auditoren.Rol_ID
            WHERE score.Audit_ID = '$auditID' AND score.Audittype = '$type'
            ";
           $content = $this->handleQuery($query);
        
        return $content;   
    }
    function getRoles(){
        $query = "SELECT Rol_ID, Rol FROM rol";
     
        $content = $this->handleQuery($query);
        
        return $content;    
    }
    function getScore($auditID, $auditorID, $indicatorID, $type){
        $query = "SELECT Score, Toelichting 
                  FROM score 
                  WHERE Audit_ID='$auditID' AND Auditor_ID = '$auditorID' AND Indicator_ID = '$indicatorID' AND Audittype ='$type'";
     
        $content = $this->handleQuery($query);
        
        return $content;    
    }
    function validateKey(){
        $query = "SELECT loginKey FROM login";
     
        $content = $this->handleQuery($query);
        
        return $content;   
    }
    function setAuditor($naam, $rol){
        $query = "INSERT INTO auditoren (Naam, Rol_ID, AuditType_ID) VALUES('$naam', '$rol', '1')";
        
        $content = $this->writeQuery($query);
        
        return $content;
    }
    function getIndicatoren($auditID) {
        $query = "SELECT indicatoren.Indicator, indicatoren.Indicator_ID, kenmerken.Kenmerk, indicatoren.Kenmerk_ID
                 FROM indicatoren
                 INNER JOIN kenmerken ON kenmerken.Kenmerk_ID = indicatoren.Kenmerk_ID
                 INNER JOIN auditinhoud ON auditinhoud.Kenmerk_ID = indicatoren.Kenmerk_ID
                 WHERE auditinhoud.Audit_ID = '$auditID'";
        
        $content = $this->handleQuery($query);
        
        return $content;
    }
    function getIndicatoren2($auditID) {
        $query = "SELECT Audit.AuditNaam, Audit.Audit_ID, Kenmerken.Kenmerk, Indicatoren.Indicator
FROM (Kenmerken INNER JOIN Indicatoren ON Kenmerken.Kenmerk_ID = Indicatoren.Kenmerk_ID) 
INNER JOIN (Audit INNER JOIN AuditInhoud ON Audit.Audit_ID = AuditInhoud.Audit_ID) ON Kenmerken.Kenmerk_ID = AuditInhoud.Kenmerk_ID
WHERE audit.Audit_ID = '$auditID'";
        
        $content = $this->handleQuery($query);
        
        return $content;
    }
    function getNorm( $auditID){
         $query = "SELECT Norm, Kenmerk_ID
                  FROM auditinhoud
                  
                 
                  WHERE Audit_ID = '$auditID'";
        
        $content = $this->handleQuery($query);
        
        return $content;
    }
    function getNormPDF($auditID, $kenmerkID){
         $query = "SELECT Norm
                  FROM auditinhoud
                  WHERE Audit_ID = '$auditID'
                  AND Kenmerk_ID = '$kenmerkID'";
        
        $content = $this->handleQuery($query);
        
        return $content;
    }
    function setScore($auditID, $auditorID, $indicatorID, $score, $type){
         $query = "INSERT INTO score (Audit_ID, Auditor_ID, Indicator_ID, Score, Toelichting, Audittype) VALUES('$auditID', '$auditorID', '$indicatorID', '$score', null, '$type')";
        
        $content = $this->writeQuery($query);
        
        return $content;
    }
    function updateScore($auditID, $auditorID, $indicatorID, $score, $type){
        $query = "UPDATE score 
                 SET score='$score', toelichting='$toelichting'
                 WHERE Audit_ID='$auditID' AND Auditor_ID='$auditorID' AND Indicator_ID='$indicatorID' AND Audittype='$type'";
        
        $content = $this->writeQuery($query);
        
        return $content;
    }
    function setToelichting($auditID, $auditorID, $indicatorID, $toelichting){
         $query = "INSERT INTO score (Audit_ID, Auditor_ID, Indicator_ID, Score, Toelichting) VALUES('$auditID', '$auditorID', '$indicatorID', null, '$toelichting')";
        
        $content = $this->writeQuery($query);
        
        return $content;
    }
    function getNotitie($AuditID, $AuditorID){
        $query = "SELECT Notitie, Notitie_ID
                  FROM extra
                  WHERE Audit_ID ='$AuditID' AND Pers_ID = '$AuditorID'";
        
        $content = $this->handleQuery($query);
        
        return $content;
    }
    function updateNotitie($AuditID, $AuditorID, $Notitie){
        $query = "UPDATE extra
                  SET notitie='$Notitie'
                  WHERE Audit_ID ='$AuditID' AND Pers_ID = '$AuditorID'";
        
        
        
        $content = $this->writeQuery($query);
        
        return $content;
    }
    function setNotitie($auditID, $auditorID, $notitie){
        $query = "INSERT INTO extra (Audit_ID, Pers_ID, Notitie) VALUES('$auditID', '$auditorID', '$notitie')";
        
        $content = $this->writeQuery($query);
        
        return $content;
    }
    function updateToelichting($auditID, $auditorID, $indicatorID, $toelichting, $type){
        $query = "UPDATE score 
                 SET toelichting='$toelichting'
                 WHERE Audit_ID='$auditID' AND Auditor_ID='$auditorID' AND Indicator_ID='$indicatorID' AND Audittype ='$type'";
        
        $content = $this->writeQuery($query);
        
        return $content;
    }
    function setScoreToelichting($auditID, $auditorID, $indicatorID, $score, $toelichting, $type) {
         $query = "INSERT INTO score (Audit_ID, Auditor_ID, Indicator_ID, Score, Toelichting, Audittype) VALUES('$auditID', '$auditorID', '$indicatorID', '$score', '$toelichting', '$type')";
        
        $content = $this->writeQuery($query);
        
        return $content;
    }
    function createCSV($auditID, $auditNaam) {
        $dbManager = new dbManager;
        $content = $dbManager->createCSV($auditID, $auditNaam);
    }
    function getIndicatorIDs($auditID, $auditorID, $type){
         $query = "SELECT Indicator_ID
                  FROM score
                  WHERE Audit_ID = '$auditID' AND Auditor_ID = '$auditorID' AND Audittype='$type'";
         $content = $this->handleQuery($query);
        
        return $content;
    }
    function getAuditScores($auditID, $indicatorID){
        $query = "SELECT ROUND(AVG(Score),2)
                  FROM score
                  WHERE Audit_ID = '$auditID' AND Indicator_ID = '$indicatorID' AND Score <> '0'";
         $content = $this->handleQuery($query);
        
        return $content;
    }
     function getAuditKenmerkScores($auditID, $kenmerkID){
        $query = "SELECT ROUND(AVG(score.Score),2)
                  FROM score
                  INNER JOIN indicatoren ON indicatoren.Indicator_ID = score.Indicator_ID
                  WHERE score.Audit_ID = '$auditID' AND indicatoren.Kenmerk_ID = '$kenmerkID' AND score.Score <> '0'";
         $content = $this->handleQuery($query);
        
        return $content;
    }
     function getAuditKenmerkScoresCount($auditID, $kenmerkID){
        $query = "SELECT COUNT(score.Score)
                  FROM score
                  INNER JOIN indicatoren ON indicatoren.Indicator_ID = score.Indicator_ID
                  WHERE score.Audit_ID = '$auditID' AND indicatoren.Kenmerk_ID = '$kenmerkID' AND score.Score <> '0'";
         $content = $this->handleQuery($query);
        
        return $content;
    }
    function getAuditScoreSTDDEV($auditID, $indicatorID){
      
     $query = " SELECT ROUND(stddev(Score),2)
                FROM score
                WHERE Audit_ID = '$auditID' AND Indicator_ID = '$indicatorID' AND Score <>'0'";
                
         $content = $this->handleQuery($query);
        
        return $content;
    }
   function getScoreCount($auditID, $indicatorID){
         $query = "SELECT COUNT(Score)
                  FROM score
                  WHERE Audit_ID = '$auditID' AND Indicator_ID = '$indicatorID' AND score.Score <>'0'";
         $content = $this->handleQuery($query);
        
        return $content;
   }
   function getIndicatorOpmerkingen($auditID, $indicatorID) {
       $query = "SELECT Toelichting
                FROM score
                WHERE Audit_ID = '$auditID' AND Indicator_ID = '$indicatorID' AND Toelichting <>''";
         $content = $this->handleQuery($query);
        
        return $content;
   }
      function getIndicatorOpmerkingenType($auditID, $indicatorID, $type) {
       $query = "SELECT auditoren.Naam, score.Toelichting
                FROM score
                INNER JOIN auditoren ON auditoren.Pers_ID = score.Auditor_ID 
                INNER JOIN rol ON rol.Rol_ID = auditoren.Rol_ID
                WHERE Audit_ID = '$auditID'
                AND Indicator_ID = '$indicatorID'
                AND score.Audittype = '$type'
                AND Score <> '0'
                 ";
         $content = $this->handleQuery($query);
        
        return $content;
   }
   function getKenmerkenAudit($auditID){
        $query = "SELECT kenmerken.Kenmerk_ID, Kenmerk
        FROM kenmerken
        INNER JOIN auditinhoud ON auditinhoud.Kenmerk_ID = kenmerken.Kenmerk_ID
        WHERE auditinhoud.Audit_ID = '$auditID'";
     
        $content = $this->handleQuery($query);
        
        return $content;    
    } 
    
   function PreventScoreRequestFloodKenmerk($auditID, $kenmerkID){
        $query = "SELECT ROUND(AVG( score.Score ),2), 
       (SELECT COUNT(score.Score) FROM score INNER JOIN indicatoren ON indicatoren.Indicator_ID = score.Indicator_ID WHERE score.Audit_ID = '$auditID' AND indicatoren.Kenmerk_ID = '$kenmerkID' AND score.Score <> '0')
FROM score
INNER JOIN indicatoren ON indicatoren.Indicator_ID = score.Indicator_ID
WHERE score.Audit_ID = '$auditID'
AND indicatoren.Kenmerk_ID = '$kenmerkID'
AND score.Score <> '0'";
        $content = $this->handleQuery($query);
        
        return $content;   
    }
   
    function PreventScoreRequestFloodKenmerkType($auditID, $kenmerkID, $type){
        $query = "SELECT ROUND(AVG( score.Score ),2), 
       (SELECT COUNT(DISTINCT score.Score) FROM score INNER JOIN indicatoren ON indicatoren.Indicator_ID = score.Indicator_ID INNER JOIN auditoren ON auditoren.Pers_ID = score.Auditor_ID INNER JOIN rol ON rol.Rol_ID = auditoren.Rol_ID WHERE score.Audit_ID = '$auditID' AND indicatoren.Kenmerk_ID = '$kenmerkID' AND score.Audittype = '$type' AND score.Score <> '0')
FROM score 
INNER JOIN indicatoren ON indicatoren.Indicator_ID = score.Indicator_ID
        INNER JOIN auditoren ON auditoren.Pers_ID = score.Auditor_ID
        INNER JOIN rol ON rol.Rol_ID = auditoren.Rol_ID
WHERE score.Audit_ID = '$auditID'
AND indicatoren.Kenmerk_ID = '$kenmerkID'
AND score.Audittype = '$type'        
AND score.Score <> '0'";
        $content = $this->handleQuery($query);
        
        return $content;   
    }
    function PreventScoreRequestFloodIndicator($auditID, $indicatorID, $kenmerkID){
        $query = "SELECT ROUND(AVG(Score),2) , 
        (SELECT ROUND(stddev(Score),2) FROM score WHERE Audit_ID = '$auditID' AND Indicator_ID ='$indicatorID' AND score.Score <> '0')
                            , (SELECT COUNT(Score) FROM score WHERE Audit_ID = '$auditID' AND Indicator_ID = '$indicatorID' AND score.Score <> '0')
                                    , (SELECT Norm FROM auditinhoud WHERE Kenmerk_ID ='$kenmerkID')
                FROM score
                WHERE Audit_ID = '$auditID'
                AND Indicator_ID = '$indicatorID'
                AND Score <> '0'
                ";

        $content = $this->handleQuery($query);
        
        return $content;   
    }
     function getIndicatorenScore($auditID, $type){
        $query = "SELECT ROUND(AVG(score.Score),2)
                FROM score
                INNER JOIN auditoren ON auditoren.Pers_ID = score.Auditor_ID 
        INNER JOIN rol ON rol.Rol_ID = auditoren.Rol_ID 
        WHERE score.Audit_ID = '$auditID' AND score.Audittype = '$type' AND score.Score <> '0'
                ";

        $content = $this->handleQuery($query);
        
        return $content;   
    }
    function getIndicatorenDev($auditID, $type){
        $query = "SELECT ROUND(stddev(score.Score),2)
        FROM score 
        INNER JOIN auditoren ON auditoren.Pers_ID = score.Auditor_ID 
        INNER JOIN rol ON rol.Rol_ID = auditoren.Rol_ID 
        WHERE score.Audit_ID = '$auditID'  AND score.Audittype = '$type' AND score.Score <> '0'
                ";

        $content = $this->handleQuery($query);
        
        return $content;   
    }
    function getIndicatorenCount($auditID, $type){
        $query = "SELECT ROUND(AVG(score.Score),2)
                FROM score
                INNER JOIN auditoren ON auditoren.Pers_ID = score.Auditor_ID 
        INNER JOIN rol ON rol.Rol_ID = auditoren.Rol_ID 
        WHERE score.Audit_ID = '$auditID' AND score.Audittype = '$type' AND score.Score <> '0'
                ";

        $content = $this->handleQuery($query);
        
        return $content;   
    }
     function PreventScoreRequestFloodIndicatorType($auditID, $indicatorID, $type){
        $query = "SELECT ROUND(AVG(score.Score),2), ROUND(stddev(score.Score),2), COUNT(DISTINCT score.Score)
        
                FROM score
                INNER JOIN auditoren ON auditoren.Pers_ID = score.Auditor_ID 
                INNER JOIN rol ON rol.Rol_ID = auditoren.Rol_ID
                INNER JOIN indicatoren ON indicatoren.Indicator_ID = score.Indicator_ID
               
                WHERE score.Audit_ID = '$auditID'
                AND score.Indicator_ID = '$indicatorID'
                AND score.Audittype = '$type'
                AND score.Score <> '0'
                ";

        $content = $this->handleQuery($query);
        
        return $content;   
    }
  function getInternScores($auditID, $indicatorID, $type){
       $query = "SELECT ROUND(AVG(score.Score),2)
                FROM score
                INNER JOIN auditoren ON auditoren.Pers_ID = score.Auditor_ID 
                INNER JOIN rol ON rol.Rol_ID = auditoren.Rol_ID             
                WHERE score.Audit_ID = '$auditID'
                AND score.Indicator_ID = '$indicatorID'
                AND score.Audittype = '$type'
                AND score.Score <> '0'
                ";
       $content = $this->handleQuery($query);
        
        return $content;  
  }
    
    function getAllKenmerken() {
        $query = "SELECT kenmerken.Kenmerk_ID, Kenmerk FROM kenmerken";
        
        $content = $this->handleQuery($query);
        
        return $content;
    }
    function getAllIndicatoren($kenmerkID) {
        $query = "SELECT indicatoren.Indicator, indicatoren.Indicator_ID, kenmerken.Kenmerk, indicatoren.Kenmerk_ID
                 FROM indicatoren
                 INNER JOIN kenmerken ON kenmerken.Kenmerk_ID = indicatoren.Kenmerk_ID
                 WHERE kenmerken.Kenmerk_ID = '$kenmerkID'";
        
        $content = $this->handleQuery($query);
        
        return $content;
    }
    
    function getNewIndicatoren($audit_ID) {
        $query = "SELECT audit.AuditIndicatoren FROM audit WHERE Audit_ID = '$audit_ID'";
        
        $content = $this->handleQuery($query);
        
        return $content;
    }
    
    function getAllNewIndicatoren(){
        $query = "SELECT indicatoren.Indicator, indicatoren.Indicator_ID, kenmerken.Kenmerk, indicatoren.Kenmerk_ID
                 FROM indicatoren
                 INNER JOIN kenmerken ON kenmerken.Kenmerk_ID = indicatoren.Kenmerk_ID";
        
        $content = $this->handleQuery($query);
        
        return $content;
    }
    
    function slaKenmerkOp($kenmerk){
        $query = "INSERT INTO kenmerken (Kenmerk_ID, Kenmerk) VALUES(null, '$kenmerk')";
        
        $content = $this->writeQuery($query);
        
        return $content;
    }
    
    function slaIndicatorOp ($kenmerk_ID, $indicator) {
        $query = "INSERT INTO indicatoren (Kenmerk_ID, Indicator) VALUES('$kenmerk_ID', '$indicator')";
        $content = $this->writeQuery($query);
        return $content;
    }
    function getIndicatorSingle ($indicatorID) {
        $query = "SELECT indicatoren.Indicator, indicatoren.Indicator_ID FROM indicatoren WHERE indicatoren.Indicator_ID = '$indicatorID'";
        $content = $this->handleQuery($query);
        return $content;
    }
    function saveAudit($naam, $school, $doel, $indicatoren) {
        $query = "INSERT INTO audit (AuditNaam, AuditSchool, AuditIndicatoren, AuditDoel) VALUES('$naam', '$school', '$indicatoren', '$doel')";
        
        $content = $this->writeQuery($query);
        
        return $content;
    }
    function getLastSavedAudit() {
        $query = "SELECT audit.Audit_ID FROM audit ORDER BY Audit_ID DESC LIMIT 0,1";
        $content = $this->handleQuery($query);
        return $content;
    }
    function saveNormen($auditID, $id, $norm) {
        $query = "INSERT INTO auditinhoud (Audit_ID, Kenmerk_ID, Norm) VALUES('$auditID', '$id', '$norm')";
        $content = $this->writeQuery($query);
        return $content;
    }
    function getAuditInfo($auditID){
        $query = "SELECT AuditNaam, AuditSchool, AuditIndicatoren, AuditDoel FROM audit WHERE Audit_ID = '$auditID'";
        $content = $this->handleQuery($query);
        return $content;
}
    function getSpecificNorm($kenmerkID, $auditID) {
        $query = "SELECT auditinhoud.Norm FROM auditinhoud WHERE Kenmerk_ID='$kenmerkID' AND Audit_ID='$auditID'";
        $content = $this->handleQuery($query);
        return $content;
    }
    function getNormen($auditID) {
        $query = "SELECT auditinhoud.Norm, auditinhoud.Kenmerk_ID FROM auditinhoud WHERE auditinhoud.Audit_ID='$auditID'";
        $content = $this->handleQuery($query);
        return $content;
    }
    function getSpecificKenmerk($kenmerkID) {
        $query = "SELECT kenmerken.Kenmerk FROM kenmerken WHERE Kenmerk_ID='$kenmerkID'";
        $content = $this->handleQuery($query);
        return $content;
    }
    function updateIndicatoren($indicatoren) {
        $query = "UPDATE audit SET AuditIndicatoren='$indicatoren'";
        $content = $this->writeQuery($query);
        return $content;
    }
    function updateNorm($auditID, $kenmerkID, $norm) {
        $query = "UPDATE auditinhoud SET Norm='$norm' WHERE Audit_ID='$auditID' AND Kenmerk_ID='$kenmerkID'";
        $content = $this->writeQuery($query);
        return $content;
    }
    function getKenmerkIndicator($indicatorID) {
        $query = "SELECT indicatoren.Kenmerk_ID FROM indicatoren WHERE Indicator_ID='$indicatorID'";
        $content = $this->handleQuery($query);
        return $content;
    }
}
?>