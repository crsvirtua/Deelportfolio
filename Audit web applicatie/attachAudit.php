<?php
    require_once("_include/queryManager.php");
    ini_set('session.gc_maxlifetime', 28800);
session_set_cookie_params(28800);
session_start();
if($_SESSION['loggedin']=='logged'){
    $auditID = $_GET['a'];
    
    $auditorID = $_GET['n'];
    $type = $_GET['t'];
    $getData = new queryManager;
    $audit = $getData->getAudit($auditID);
    $auditor = $getData->getAuditor($auditorID);
    //$indicator = $getData->getIndicatoren($auditID);
    //$kenmerken = $getData->getKenmerkenAudit($auditID);
    $bijlagen = $getData->getBijlage($auditID);
    if(empty($auditID)|| empty($auditorID)){
       header('Location: startAudit.php');
  }
  if($_POST['Back'] == 'TERUG'){
      header('Location: perfAudit.php?a='.$auditID.'&n='.$auditorID.'&t='.$type.'');
  }

  if($_POST['Bijlage'] == 'UPLOADEN'){
       print_r($_POST);
        if(sizeof($_FILES) !=0){
           if($_FILES["addfile"]["error"] > 0){
               //echo $_FILES["addfile"]["error"];
               if($_FILES["addfile"]["error"] == 4){
                        echo "U HEEFT NIKS GESELECTEERD OF DE FILE KAN NIET GEUPLOAD WORDEN";
               }else{
                //for error checking.
              echo "Error: ".$_FILES["addfile"]["error"]. "<br>";
               }
           }else{
               if(file_exists("upload/".$_FILES["addfile"]["name"])){
                 
                   move_uploaded_file($_FILES["addfile"]["tmp_name"], "upload/".$_FILES["addfile"]["name"]);
                 //  Echo "Het bestand is opgeslagen!";
                   $path = "http://".$_SERVER['SERVER_NAME']."/upload/".$_FILES["addfile"]["name"];
                   $comment =$_POST["beschrijving"];
                   $bijlage = $getData->setBijlage($auditID, $_FILES["addfile"]["name"], $path, $comment);
                    ?><script>
                       location.reload(true);
                   </script><?php
               }else{
                   move_uploaded_file($_FILES["addfile"]["tmp_name"], "upload/".$_FILES["addfile"]["name"]);
                   //Echo "Het bestand is opgeslagen!";
                   $path = "http://".$_SERVER['SERVER_NAME']."/upload/".$_FILES["addfile"]["name"];
                   $comment =$_POST["beschrijving"];
                   $bijlage = $getData->setBijlage($auditID, $_FILES["addfile"]["name"], $path, $comment);
                  ?>
                   <script>
                       location.reload(true);
                   </script><?php
               }
           
           }
        }else{
           echo "U HEEFT NIKS GESELECTEERD";
        }
        unset($_FILES["addfile"]);
    }
    unset($_POST["Bijlage"]);
    unset($_POST["Back"]);
    unset($_POST["beschrijving"]);
       if($_POST['REMOVE'] == 'VERWIJDER SELECTIE'){
       unset($_POST["REMOVE"]);
           print_r($_POST);
         
           print_r($_POST["Verwijder"]);
       foreach($_POST["Verwijder"] as $value){ 
          
              $removedata = $getData->removeBijlage($auditID, $value["Verwijder"]);
              ?>
              <script>
                       location.reload(true);
                   </script><?php
   }

   
       }
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="_include/css/perfAudit.css"/>
        <!--[if IE]><link rel="stylesheet" type="text/css" href="_include/css/perfAuditIE.css"/><![endif]--> 
        <title>Audit App Pilot - Audit Uitvoeren</title>
       
    </head>
    <body id="body">
        <div id="contentcontainer">
            <div id="pageTitle">
                BIJLAGES
            </div>
            <div id="pageContent">
                <div id="auditInfo">
                    <?php $auditNameLength = strlen($audit[0]['AuditNaam']); ?>
                    <?php if($auditNameLength < '20') { ?>
                        <div class="auditInfoFieldLong"><?php echo $audit[0]['AuditNaam']; ?></div>
                    <?php } else { ?>
                        <div class="auditInfoFieldLong2"><?php echo $audit[0]['AuditNaam']; ?></div>
                    <?php } ?>
                    <div class="auditInfoField"><?php echo $auditor[0]['Naam']; ?></div>
                    <div class="auditInfoField"><?php echo $auditor[0]['Rol']; ?></div>
                    <div class="auditInfoFieldLast"><?php echo $auditor[0]['AuditType']; ?></div>
                
                                                   
                </div>
                <form action="" method="POST" enctype="multipart/form-data">
                      <div class="kenmerkContainer">
     <?php   if(empty($bijlagen)){
                            Echo "Er zijn geen bijlages <br /><br /><br/ >";
                        }else{
                            foreach($bijlagen as $value){?>
                               
                         <div class="kenmerkHeader">
                                    BIJLAGE
                                   
                                </div>
                                <div class="kenmerkName">
                                       <?php echo'<a href="'.$value["Bijlage_Path"].'"> '.$value["Bijlage_Naam"].'</a> ';   ?>                           
                                    </div>
                         "
                          <input name="Verwijder[]" type="checkbox" class="submitFormButton" value="<?php echo$value["Bijlage_ID"];?>" style="cursor:pointer;"/>
                           <br /> <br /> <br /> <br />  <br /> 
                          <div class="indicatorHeader">
                              BESCHRIJVING
                          </div>
                           <div class="indicatorName">
                              <?php echo$value["Bijlage_Comment"];?>
                          </div>
                           <br /> <br /> <br /> <br />  <br /> 
                           <?php }
                        }
?>
                  <input name="REMOVE" type="submit" class="submitFormButtonLarge" value="VERWIJDER SELECTIE" style="cursor:pointer;"/>
                      
                        
                       
                    </div>
                               
                                                                   </div>
                                
                                         <div id="bijlage"><br/>                                             
                                         <div id="bottomLeft"> 
                        <input name="Back" type="submit" class="submitFormButtonLarge" value="TERUG" style="cursor:pointer;"/>
                      
                        
                    </div>
                        <div id ="bottomRight">
                          BIJLAGE TOEVOEGEN <br /><br />
                        <input name ="addfile" type="file" /> <br />
                        <br/>
                     
                       <textarea class="OpmerkingField" name="beschrijving" >Hier uw beschrijving van de bijlage</textarea><br /> <br />
                  <input name="Bijlage" type="submit" class="submitFormButtonLarge" value="UPLOADEN" style="cursor:pointer;"/>
                                         
                    </div>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>
<?php  }else{ 
$_SESSION['notloggedin'] = 'loggedout'; 
header("Location: index.php");
}?>
