<?php
    require_once MODEL_CSV;
    session_start();
    require_once MODEL_USER;

    $checkUser = new User;
    $authUser = $checkUser->authenticateUser($_SESSION['uname'], $_SESSION['authcode']);

    if($authUser == 'authUnSucc') {
        session_destroy();
        header('Location: '.BACKEND_LINK_ROOT);
    } else {}

    //determine what rights this user has on this page:
    $currentPage = 'uploadCSV';
    $rights = $checkUser->checkRights($_SESSION['authcode'], $_SESSION['uname'], $currentPage);
    if($rights == 'VIEW_EDIT_FALSE') {
        if($_SESSION["lastpage"] == '') { $_SESSION["lastpage"] = 'overview'; }
        header('Location:'.$_SESSION["lastpage"]);
    }
    $_SESSION["lastpage"] = $currentPage;
    
    $uname = $_SESSION['uname'];

    $content = new CSV;
    //$content2 = $content->import($CSVname);
    
    //scan the available csv files:
    $existingFiles = $content->checkExisting();
    $doneFiles = $content->checkDone();
    
    //if CSV files were selected:
    if(isset($_POST)) {
        if(!empty($_POST)) {
            //start the import function:
            $runFiles = $content->import($_POST);
        }
    }
    if($runFiles == 'done') {
        $runFiles = '';
        header('Location:'.$_SESSION["lastpage"]);
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <?php echo '<link rel="stylesheet" type="text/css" href="'.CSSB_DEFAULT.'" />'; ?>
        <?php echo '<link rel="stylesheet" type="text/css" href="'.CSSB_HEADER.'" />'; ?>
        <?php echo '<link rel="stylesheet" type="text/css" href="'.CSSB_CSV.'" />'; ?>
        <title>SCHOOLINZICHT - Backend</title>
    </head>
    <body class="body">
        <?php include_once("views/components/backendHeader.php"); ?>
        <div id="contentcontainer">
            <?php if(!empty($existingFiles)) { ?>
            <div class="pageTitle">
                Kies een of meer van de beschikbare csv bestanden die u wilt laten importeren:
            </div>
            <form method="POST" action="">
                <?php
                    $i=0;
                    foreach($existingFiles as $value) { ?>
                    <div class="itemContainer">
                        <div class="itemleft"><input type="checkbox" name="<?php echo $i; ?>" value="<?php echo $value['name']; ?>"/></div>
                        <div class="itemright"><?php echo $value['name']; ?></div>
                        <div class="size"><?php echo $value['size']." <b>kb</b> groot"; ?> </div>
                    </div>

                <?php $i++; } ?>
                <div id="submitbutton">
                     <input type="submit" value="DOORVOEREN" class="submit">
                </div>
                <?php } else {  ?>
                    <div class="pageTitle">
                        Er zijn geen CSV bestanden geupload die nog doorgevoerd kunnen worden.
                    </div>
                <?php } ?>

            </form>
            <?php if(!empty($doneFiles)) { ?>
                <div class="pageTitle">
                    Bestanden die al doorgevoerd zijn:
                </div>
                <?php
                    $i=0;
                    foreach($doneFiles as $value) { ?>
                    <div class="itemContainer">
                        <div class="itemleftwide"><?php echo $value['date']; ?></div>
                        <div class="itemright"><?php echo $value['name']; ?></div>
                        <div class="size"><?php echo $value['size']." <b>kb</b> groot"; ?></div>
                    </div>
                <?php $i++; } } else {} ?>
        </div>
    </body>
</html>