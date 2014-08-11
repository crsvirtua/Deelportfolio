<?php

//Designed and written in the year 2012, for ASG, by:
//Peter van Kleef, Richard Floris & Pepijn de Vries.

//old file, not being used in the application.
//used as reference instead

include_once MODELS_PATH.'/menu.php';
//dit zou uit de session ($_SESSION['accessLevel']) moeten komen:
$userAccessLevel = '3';
$getFunction = 'getDetails';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <?php echo '<link rel="stylesheet" type="text/css" href="'.CSSB_DEFAULT.'" />'; ?>
        <?php echo '<link rel="stylesheet" type="text/css" href="'.CSSB_HEADER.'" />'; ?>
        <?php echo '<link rel="stylesheet" type="text/css" href="'.CSSB_EDITCONTENT.'" />'; ?>

        <title>SCHOOLINZICHT - Backend</title>
    </head>
    <body class="body">
        <div id="fullheader">
            <div id="fulltop">
                <div id="topcontainer">
                    <div id="welcome">
                        <i>welkom</i> <b>Admin</b>
                    </div>
                    <div id="sitemenu">
                        <ul class="none">
                            <li class="<?php if($page == 'updates') { echo 'sitemenuitemflagsactive'; } else { echo 'sitemenuitemflags'; } ?>">
                                <?php echo '<a href="'.URL_ROOT.'updatesList"><b><span>0</span></b> WIJZIGINGEN &amp; <b><span>0</span></b> FLAGS</a>';?>
                            </li>
                            <?php 
                                $contentitems = new menu;
                                $content = $contentitems->getMenu(); 
                                $i = 0;
                                foreach($content as $value) {
                                    ?>
                                        <li class="<?php if($page == $content[$i]["menuTitle"] || ($page == '' && $content[$i]["menuTitle"] == 'overview')) { echo 'sitemenuitemactive'; } else { echo 'sitemenuitem'; } ?>">
                                           <?php 
                                                echo '<a href="'.URL_ROOT . $content[$i]["menuLink"]. '">'; 
                                                    print_r(strtoupper($content[$i]['menuTitle'])); 
                                                echo '</a>'; 
                                           ?>                                     
                                        </li>
                                    <?php
                                    $i++;
                                }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div id="fullsub">
                <div id="subcontainer">
                    <div class="subbutton">
                        <a href="index.php?p=csvupload">upload CSV</a>
                    </div>
                    <div class="subbutton">
                        <a href="#">logout</a>
                    </div>
                </div>
            </div>
        </div>
        <div id="contentcontainer">
            <div id="editcontentcontainer">
                <div id="editcontentleftrightcontainer">
                    <div id="editcontentleftcontainer">
                        <div class="editcontentitem">
                            <div class="editcontentitemtitle">Brin nr:</div>
                            <input type="text" name="brinnr" class="editcontentitemcontent" value="14QC00" readonly="readonly"/>
                        </div>
                        <div class="editcontentitem">
                            <div class="editcontentitemtitle">Emailadres:</div>
                            <input type="text" name="emailadres" class="editcontentitemcontentgrey" readonly="readonly" value="randomemailadres1@schoolbestuur.nl" />
                        </div>
                        <div class="editcontentitem">
                            <div class="editcontentitemtitle">Schoolnaam:</div>
                            <input type="text" name="schoolnaam" class="editcontentitemcontentgrey" readonly="readonly" value="Montessori Stad" />
                        </div>
                        <div class="editcontentitem">
                            <div class="editcontentitemlongleft">
                                <div class="editcontentitemtitle">Missie:</div>
                            </div>
                            <div class="editcontentitemlongright">
                                <textarea cols="1" rows="1" name="schoolnaam" class="editcontentitemcontentlong"><?php echo "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ligula urna, ornare nec dapibus eget, rhoncus in tortor. Duis cursus dignissim posuere. Phasellus accumsan felis non nisl facilisis ultricies. Donec scelerisque congue nulla, eu commodo eros viverra scelerisque.";?></textarea>
                                <div class="editcontentitemlonginftext">
                                    <div class="editcontentitemlonginftexttitle"><b>voeg infotext toe</b> <i></i></div>
                                </div>                
                            </div>
                        </div>
                        <div class="editcontentitem">
                            <div class="editcontentitemlongleft">
                                <div class="editcontentitemtitle">Missie:</div>
                            </div>
                            <div class="editcontentitemlongright">
                                <textarea cols="1" rows="1" name="schoolnaam" class="editcontentitemcontentlong"><?php echo "Lorem ipsum dolor sit amet, [#inf005] consectetur adipiscing elit. Sed ligula urna, ornare nec dapibus eget, rhoncus in tortor. Duis cursus dignissim posuere. Phasellus accumsan felis non nisl facilisis ultricies. Donec scelerisque congue nulla, eu commodo eros viverra scelerisque.";?></textarea>
                                <div class="editcontentitemlonginftext">
                                    <div class="editcontentitemlonginftexttitle"><b>inf005</b> <i>schrijf text:</i></div>
                                    <textarea cols="1" rows="1" name="schoolnaam" class="editcontentitemcontentlonginftext"><?php echo "Lorem ipsum dolor sit amet, consectetur adipiscing"; ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="editcontentitem">
                            <div class="editcontentitemtitletab">Tabblad:</div>
                            <input type="text" name="brinnr" class="editcontentitemcontenttabgrey" readonly="readonly" value="Onderwijsrendement" />
                            <div class="editcontentitemtitletab">Context:</div>
                            <div class="editcontentitemcontenttab">
                                <form>
                                    <input name="conderwijsrendement" value="aan" type="radio" class="radiobutton" />AAN
                                    <input name="conderwijsrendement" value="uit" type="radio" checked class="radiobutton" />UIT
                                </form>
                            </div>
                            <div class="editcontentitemtitletab">Grafiek:</div>
                            <div class="editcontentitemgraphtab">GRAPH HERE!</div>
                        </div>
                        <div class="editcontentitem">
                            <div class="editcontentitemtitletab">Tabblad:</div>
                            <input type="text" name="brinnr" class="editcontentitemcontenttabgrey" readonly="readonly" value="Onderwijsrendement" />
                            <div class="editcontentitemtitletab">Context:</div>
                            <div class="editcontentitemcontenttab">
                                <form>
                                    <input name="conderwijsrendement" value="aan" type="radio" checked class="radiobutton" />AAN
                                    <input name="conderwijsrendement" value="uit" type="radio" class="radiobutton" />UIT
                                </form>
                            </div>
                            <div class="editcontentitemtitletab">Grafiek:</div>
                            <div class="editcontentitemgraphtab">GRAPH HERE!</div>
                            <div class="editcontentitemtitletab">Context:</div>
                            <textarea cols="1" rows="1" class="editcontentitemcontexttab">context goes here!</textarea>
                        </div>
                    </div>
                    <div id="editcontentrightcontainer">
                        <div class="flagitemcontainer">
                            <div class="flagitemtop">
                                <div class="flagitemname">
                                    <div class="flagitemnameimage">
                                        <?php echo '<img src="'.BACKEND_IMAGES_PATH.'flagged.png" alt="" class="img" />'; ?>
                                    </div>
                                    <div class="flagitemnametext">FLAG <i>(plaats een opmerking)</i></div>
                                </div>
                                <div class="flagitemremaining">4/500</div>
                                <div class="flagitemdelete">
                                    <?php echo '<img src="'.BACKEND_IMAGES_PATH.'remove.png" alt="" class="img" />'; ?>
                                </div>
                            </div>
                            <textarea cols="1" rows="1" class="flagitemcontent">test</textarea>
                        </div>
                        <div class="flagitemcontainer">
                            <div class="flagitemtop">
                                <div class="flagitemname">
                                    <div class="flagitemnameimage">
                                        <?php echo '<img src="'.BACKEND_IMAGES_PATH.'flagged.png" alt="" class="img" />'; ?>
                                    </div>
                                    <div class="flagitemnametext">FLAG <i>(plaats een opmerking)</i></div>
                                </div>
                                <div class="flagitemremaining">7/500</div>
                                <div class="flagitemdelete">
                                    <?php echo '<img src="'.BACKEND_IMAGES_PATH.'remove.png" alt="" class="img" />'; ?>
                                </div>
                            </div>
                            <textarea cols="1" rows="1" class="flagitemcontent">testing</textarea>
                        </div>
                    </div>
                </div>
            </div>
            ...
        </div>
    </body>
</html>