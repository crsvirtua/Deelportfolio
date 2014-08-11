<?php

unset($_POST['uploadData']);
if(!empty($_POST)) {
   
    foreach($_POST as $key->$value) {
        //if the post is a notitie:
        if($key == $y.'&notitie') {
            echo "lol<br/>";
        }
        //if the post is a samenvatting:
        elseif($key == $y.'&samenvatting') {
            echo "troll<br/>";
        }
        //if the post is something else (score, opmerking):
        else {
              if(!empty($exScoresArray)) {
                if(!in_array($y, $exScoresArray)) {
                //set the update arrays if the ID is already part of the exScoresArray!: 
                    if($_POST[$y.'&score'] == '') {}
                    else {
                        $updateScoreArray[$p]['indicator'] = $y;
                        $updateScoreArray[$p]['score'] = $_POST[$y.'&score'];
                    }
                    if($_POST[$y.'&toelichting'] == '') {}
                    else {
                        $updateToelichtingArray[$p]['indicator'] = $y;
                        $updateToelichtingArray[$p]['toelichting'] = $_POST[$y.'&toelichting'];
                    }
                }
                else {
                    //set the upload arrays, if the ID is not part of the existingScoresArray!
                    if($_POST[$y.'&score'] == '' && $_POST[$y.'&toelichting'] == '') {}
                    else {
                        $uploadArray[$p]['indicator'] = $y;
                        $uploadArray[$p]['score'] = $_POST[$y.'&score'];
                        $uploadArray[$p]['toelichting'] = $_POST[$y.'&toelichting'];
                    }

                }
                $p++;
            }
            else {
                //set the upload arrays, if there is no existingScoresArray!
                if($_POST[$y.'&score'] == '' && $_POST[$y.'&toelichting'] == '') {}
                else {
                    $uploadArray[$p]['indicator'] = $y;
                    $uploadArray[$p]['score'] = $_POST[$y.'&score'];
                    $uploadArray[$p]['toelichting'] = $_POST[$y.'&toelichting'];
                }
                $p++;
            }
            $y++;
        }
    }
}
?>
