<?php
  require_once(".../_include/queryManager.php");
$content = 'A Test overflow<br>A Test overflow<br>A Test overflow<br>
<img src="./res/logo.gif" alt="logo" style="width: XXXmm"><br>
B Test overflow<br>B Test overflow<br>B Test overflow<br>
<img src="./res/logo.gif" alt="logo" style="width: XXXmm"><br>
C Test overflow<br>C Test overflow<br>C Test overflow<br>';
session_start();

$auditID= $_SESSION["AuditIDExtern"];
$getData = new queryManager;
    $audit = $getData->getAudit($auditID);
   // $auditoren = $getData->getAuditors();
    
    $type = "Intern";
    
    $auditoren = $getData->getScoredAuditors($auditID, $type);
    if(!empty($auditoren[0])){
    $auditoren = array_map("unserialize", array_unique(array_map("serialize", $auditoren)));}
   

     $conclusie = $getData->getConclusionsType($auditID, $type);
     
     $datum = $getData->getDatum($auditID, $auditoren[0]["Pers_ID"]);
    
    $notities = $getData->getNotes($auditID);
    
     //get all indicators:
    $indicatoren = $getData->getAllNewIndicatoren();

    //get the indicators that are part of this Audit:
    $indicator = $getData->getNewIndicatoren($auditID);
    
   // print_r($indicatoren);
    //put the indicators of this Audit in an array:
    $indicator = explode(",", $indicator[0]["AuditIndicatoren"]);
    $bijlagen = $getData->getBijlage($auditID);
    $opmerkingen = $getData->getRapportOpmerkingen($auditID, $type);
    
    $o=0;
    if(!empty($opmerkingen)){
        foreach($opmerkingen as $value){
        if(!empty($value["Toelichting"])){
            $opmerkingenlijst[$o]["Indicator_ID"] = $value["Indicator_ID"];
            $opmerkingenlijst[$o]["Indicator"] = $value["Indicator"];
            $opmerkingenlijst[$o]["Toelichting"] = $value["Toelichting"];
         $o++;  
        }
    }}
  //  print_r($opmerkingen);
       $count=0;
    foreach($indicatoren as $value){
        
        if(in_array($value["Indicator_ID"], $indicator)){
              $indicatorenlijst[$count] = $value;
              $count++;
        }
    }
   // print_r($indicatorenlijst);
    $count = 0;
   // print_r($indicator);
    foreach($indicatorenlijst as $value){
        $kenmerklijst[$count]["Kenmerk_ID"] = $value["Kenmerk_ID"];
        $kenmerklijst[$count]["Kenmerk"] = $value["Kenmerk"];
      //  $kenmerklijst[$count]["Norm"] = $value["Norm"];
        
        $count++;
    }
     $kenmerken = array_map("unserialize", array_unique(array_map("serialize", $kenmerklijst)));
     
     foreach ($indicatorenlijst as $value){
         
     }
    // print_r($indicatorenlijst);
?>
<style type="text/css">
<!--
#div.zone
{
    border: solid 2mm #66AACC;
    border-radius: 3mm;
    padding: 1mm;
    background-color: #FFEEEE;
    color: #440000;
}
div.zone_over
{
    width: 30mm;
    height: 35mm;
    overflow: hidden;
}
#divtext
{
 position: left;
}

-->
</style>
<page style="font-size: 10pt">
    
  <?php
  ?>
    <br/><br/><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
  <img src="http://www.testomgeving.webfloris.nl/_include/images/logo.jpg" alt="ASG">  
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>INTERNE AUDIT</b> <br /><br />
  <br /><br /><br /><br /><br /><br /><br /><br /><br /><b>Auditnaam:</b><br /> <?php echo $audit[0]["AuditNaam"];?><br/><br />
  <b>Schoolnaam:</b><br/> <?php echo $audit[0]["AuditSchool"]; ?><br/><br />
  <b>Datum afname:</b><br/><?php echo $datum[0]["DatumAfname"];?> <br /><br />
  <b>Doel van de Audit:</b><br/> <?php echo $audit[0]["AuditDoel"]; ?>
</page>
<page style="font-size: 10pt">
    <b>Deelnemers en Rollen </b> <br /><br />
    <?php 
    if(!empty($auditoren[0])){
    foreach($auditoren as $value){
   
        echo "<i>Naam: </i>".$value["Naam"];
        echo "<br /><i>Rol: </i>".$value["Rol"];
        echo "<br /><br />";
        
    
    }
    }else{ echo"Er zijn geen auditoren<br /><br /><br />";}
?>
    <br /><b>Kenmerken en Indicatoren</b> <br />
   
        <?php
        $i=$indicatorenlijst[0]["Kenmerk_ID"];
                    $p=0;
                    if(empty($kenmerken)) {} else {
                        foreach($kenmerken as $value1) { 
                            $kenmerk = $value1["Kenmerk_ID"];
                           // print_r ($kensuperdata);
                          //  $kenmerkavg = $getData->getAuditKenmerkScores($auditID, $value1['Kenmerk_ID']);
                           // $kenmerkcount = $getData->getAuditKenmerkScoresCount($auditID, $value1['Kenmerk_ID']); ?>
                            <div class="kenmerkContainer">
                                   <br />
                                <div class="kenmerkName">
                                    <?php echo "<i>KENMERK:</i> ".$value1['Kenmerk'].""; ?>
                                </div>
                                <br />
                                <?php
                                foreach($indicatoren as $value) {
                                    
                                    //$norm = $getData->getNorm($value['Kenmerk_ID']);
                                    //$scores = $getData->getAuditScores($auditID, $value["Indicator_ID"]);
                                    //$stddev = $getData->getAuditScoreSTDDEV($auditID, $value["Indicator_ID"]);
                                    //$count = $getData->getScoreCount($auditID, $value["Indicator_ID"]);
                                    // All Query Requests have been replaced by one to prevent database flooding
                                    $indicatorID = $value["Indicator_ID"];
                                    $kenmerkID = $value["Kenmerk_ID"];
                                   // echo "ind:'.$indicatorID.' ken:'.$kenmerkID'";
                                   
                                    
                                  
                                    if($value['Kenmerk_ID'] == $i) { ?>
                                        <div class="indicatorContainer">
                                            
                                            <?php $stringLength = strlen($value['Indicator']); ?>
                                            <?php if($stringLength <= '65') { ?>
                                                <div class="indicatorName">
                                                    <?php echo "- ".$value['Indicator']; ?>
                                                </div>
                                            <?php }
                                            else { ?>
                                                <div class="indicatorName2">
                                                    <?php echo "- ".$value['Indicator']; ?>
                                                </div>
                                            <?php } ?>
                                        
                                        </div>
                                    <?php $p++;
                                    }
                                } ?>
                            </div>
                    <?php $i++;} }?>
     <br /><br /><b>Bijlagen:</b> <br />
     <?php if(!empty($bijlagen[0]["Bijlage_Naam"])){
         foreach($bijlagen as $value){
         echo $value["Bijlage_Naam"]."<br />";
     }
     }else{
         echo "Er zijn geen bijlages toegevoegd <br />";
     }
?>
</page>
<page style="font-size: 10pt">
    <b>Algemene conclusie</b><br/>
    <?php if(!empty($conclusie[0]["Conclusie"])){
            foreach($conclusie as $value){
        echo"<i>Naam: </i>".$value["Naam"];
        echo"<br /><br /><i>Conclusie: <br /></i>".$value["Conclusie"];
        echo "<br />";
    }
    }else { echo "Er zijn geen conclusies ingevuld <br />";}
?>
    <br />
   <br /><br /> <b>Kenmerk, Score, Streefnorm en Deelconclusie</b> <br /><br />
    <?php 
   
    foreach($kenmerken as $value){
        $scoreData = $getData->PreventScoreRequestFloodKenmerkType($auditID, $value["Kenmerk_ID"], "Extern");
        $normData = $getData->getNormPDF($auditID, $value["Kenmerk_ID"]);
        $samenvattingData = $getData->getKenmerkSamenvattingType($auditID, $value["Kenmerk_ID"], "Extern");
       // print_r($normData);
     
      
        echo"<i>KENMERK: </i>".$value["Kenmerk"]."&nbsp;&nbsp;&nbsp;";
        
        
        echo"<i>Gem. Score: </i>".$scoreData[0]["ROUND(AVG( score.Score ),2)"]."&nbsp;&nbsp;&nbsp;";
        $type ="Intern";
        $scoreData = $getData->PreventScoreRequestFloodKenmerkType($auditID, $value["Kenmerk_ID"], "Intern");
        echo"<i>Gem. Interne Score: </i>".$scoreData[0]["ROUND(AVG( score.Score ),2)"]."&nbsp;&nbsp;&nbsp;";
        echo"<i>Norm: </i>".$normData[0]["Norm"]."<br />";
        echo"<br /><i>Samenvattingen:</i><br />";
        if (!empty($samenvattingData[0]["Samenvatting"])){
            foreach ($samenvattingData as $value){
                if(!ctype_alnum($value["Samenvatting"])){
             Echo" ".$value["Samenvatting"]."<br /><br />";}
             else{
                              }
             
             }
        }
echo"";
     
    }
?>
   
</page>
<page style="font-size: 10pt">
    <b>Opmerkingen per Indicator</b><br />
    
    <?php
    //print_r($opmerkingenlijst);
    $indicator = $opmerkingenlijst[0]["Indicator_ID"];
    echo "<br />";
    echo "<u>".$opmerkingenlijst[0]["Indicator"].": </u><br />";
    foreach($opmerkingenlijst as $value){
       if($value["Indicator_ID"] == $indicator){
           Echo "Opmerking:<br />".$value["Toelichting"];
           Echo "<br /> <br />";
       }else{
           Echo "<u>".$value["Indicator"]."; </u> <br /><br />";
           Echo "Opmerking:<br />".$value["Toelichting"];
           Echo "<br /> <br />";
           $indicator = $value["Indicator_ID"];
       }
    }
    
    ?>
</page>