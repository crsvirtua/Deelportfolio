<?php
require_once MODEL_CRITERIA;
require_once MODEL_MENU;
?>
       
        <div id="logocontainer">
            <div id ="twitter"><?php echo '<a href ="https://twitter.com/SchoolinzichtAL"> <img border ="0" src="../../_include/imgFrontend/twitter.png" alt="Twitter"> </a>'?></div>
            <div id ="facebook"><?php echo '<a href ="http://www.facebook.com/pages/Schoolinzicht-Almere/483145721746261?fref=ts"> <img border ="0" src="../../_include/imgFrontend/facebook.png" alt="facebook"> </a>'?></div>
            <div id="logo"><?php echo '<a href ="../../home"> <img border ="0" src="../../_include/imgFrontend/logo.png" alt="logo" width="379" height= "115"> </a>'?>
               
            
        </div>
        </div>
        <div id="right">
            <div id="righttop">
                <div id="slogan"><b>Eerlijk en objectief</b> in wat een school biedt</div>
                <!--
                <div id="optionscontainer">
                    <div class="option"><img src="../img/flagdutch.png"></div>
                    <div class="option"><img src="../img/flagenglish.png"></div>
                    <div id="spacer"></div>
                    <div class="option">A</div>
                    <div class="option">A</div>
                </div>
                Disabled, these are could-haves.
                --> 
                <div id="searchcontainer">
                    <!--
                    <div id="searchbar">
                        typ hier uw zoekopdracht...
                    </div>
                    <div id="searchbutton">
                        ZOEKEN
                    </div>
                    Disabled, these are could-haves.
                    -->
                    
                </div>
            </div>
            <div id="menucontainer">
        <ul>
            <?php      
            
                $i=0;
                $getFunction = 'getMenu';
                $menu = new menu;
                $menucontent = $menu->showitems($getFunction);
                //Whileloop to pass through the lower category ID's 
                 while($menucontent[$i]["menuCategoryID"] != '3'){
                        $i++;
                    }
                foreach($menucontent as $value) {
                   
                        while($menucontent[$i]["menuCategoryID"] == '3') {
                            echo '<li class="menuitem"><a href="'.FRONTEND_LINK_ROOT.''.$menucontent[$i]["menuLink"].'">'.$menucontent[$i]["menuTitle"].'</a></li>';
                           $i++;
                        }   
             
                    }              
                       
            ?>
        </ul>  
    </div>
        </div>
    </div>        
</div>
