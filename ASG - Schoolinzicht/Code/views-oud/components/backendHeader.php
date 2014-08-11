<?php
require_once MODEL_MENU;
$array = explode('/',$_SERVER['REQUEST_URI']); 
array_shift($array); 
$page = $array[1];
$sub = $array[2];
?>
        <div id="fullheader">
            <div id="fulltop">
                <div id="topcontainer">
                    <div id="welcome">
                        <i>welkom</i> <b><?php echo $_SESSION['uname']; echo ", Admin"; ?></b>
                    </div>
                    <div id="sitemenu">
                        <ul class="none">
                            <li class="<?php if($page == 'updatesList') { echo 'sitemenuitemflagsactive'; } else { echo 'sitemenuitemflags'; } ?>">
                                <?php echo '<a href="'.BACKEND_LINK_ROOT.'updatesList"><b><span>0</span></b> WIJZIGINGEN &amp; <b><span>0</span></b> FLAGS</a>';?>
                            </li>
                            <?php 
                                $i = 0;
                                $contentitems = new menu;
                                $content = $contentitems->getMenu(); 
                               
                                foreach($content as $value) {
                                    if($content[$i]["menuCategoryID"] == '1') {
                                    ?>
                                        <li class="<?php if($page == $content[$i]["menuLink"]) { echo 'sitemenuitemactive'; } else { echo 'sitemenuitem'; } ?>">
                                           <?php 
                                                echo '<a href="'.BACKEND_LINK_ROOT.$content[$i]["menuLink"]. '">'; 
                                                    print_r(strtoupper($content[$i]['menuTitle'])); 
                                                echo '</a>'; 
                                           ?>                                     
                                        </li>
                                    <?php
                                        $i++;
                                    }
                                    else {
                                        $i++;
                                    }
                                }
                            ?>
                        </ul>
                    </div>
                    
                </div>
            </div>
            <div id="fullsub">
                <div id="subcontainer">
                    <div class="subbutton">
                        <?php echo '<a href="'.BACKEND_LINK_ROOT.'uploadCSV">upload CSV</a>'; ?>   
                    </div>
                    <div class="subbutton">
                        <?php echo '<a href="'.BACKEND_LINK_ROOT.'logout">logout</a>'; ?>   
                    </div>
                        <?php if($page == 'contentManagement') { 
                            if($sub == 'categories') {$submenustatus1 = 'submenuitemactive'; } else {$submenustatus1 = 'submenuitem'; }
                            if($sub == 'menuCategories') {$submenustatus2 = 'submenuitemactive'; } else {$submenustatus2 = 'submenuitem'; }
                            if($sub == 'pages') {$submenustatus3 = 'submenuitemactive'; } else {$submenustatus3 = 'submenuitem'; }
                            if($sub == 'criteria') {$submenustatus4 = 'submenuitemactive'; } else {$submenustatus4 = 'submenuitem'; }
                            echo "
                            <div id='submenu'>
                                <ul class='none'>
                                    <li class='$submenustatus1'><a href='".BACKEND_LINK_ROOT."contentManagement/categories'>Categories</a></li>
                                    <li class='$submenustatus2'><a href='".BACKEND_LINK_ROOT."contentManagement/menuCategories'>Menu Categories</a></li>
                                    <li class='$submenustatus3'><a href='".BACKEND_LINK_ROOT."contentManagement/pages'>Pages</a></li>
                                    <li class='$submenustatus4'><a href='".BACKEND_LINK_ROOT."contentManagement/criteria'>Criteria</a></li>
                                </ul>
                            </div>"; 
                        } ?>
                </div>
            </div>
        </div>