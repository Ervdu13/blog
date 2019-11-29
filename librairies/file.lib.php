<?php

function uploadMyFile()
{
    $nomOrigine = $_FILES['avatar']['name'];
    //var_dump($nomOrigine);
    //var_dump(pathinfo($nomOrigine));

 /*
    if (is_uploaded_file($_FILES['avatar']['tmp_name'])) 
    {
    
        if (rename($_FILES['monfichier']["tmp_name"],
                    $repertoireDestination.$nomDestination)) {
            echo "Le fichier temporaire ".$_FILES["monfichier"]["tmp_name"].
                    " a été déplacé vers ".$repertoireDestination.$nomDestination;
        } else {
            echo "Le déplacement du fichier temporaire a échoué".
                    " vérifiez l'existence du répertoire ".$repertoireDestination;
        }          
    } else {
        echo "Le fichier n'a pas été uploadé (trop gros ?)";
    }
*/

}

/*

array (size=1)
  'avatar' => 
    array (size=5)
      'name' => string 'logo.png' (length=8)
      'type' => string 'image/png' (length=9)
      'tmp_name' => string '/tmp/phptIaCN7' (length=14)
      'error' => int 0
      'size' => int 16603

      <?php
$nomOrigine = $_FILES['monfichier']['name'];
$elementsChemin = pathinfo($nomOrigine);
$extensionFichier = $elementsChemin['extension'];
$extensionsAutorisees = array("jpeg", "jpg", "gif");
if (!(in_array($extensionFichier, $extensionsAutorisees))) {
    echo "Le fichier n'a pas l'extension attendue";
} else {    
    $repertoireDestination = dirname(__FILE__)."/";
    $nomDestination = "fichier_du_".date("YmdHis").".".$extensionFichier;

    if (move_uploaded_file($_FILES["monfichier"]["tmp_name"], 
                                     $repertoireDestination.$nomDestination)) {
        echo "Le fichier temporaire ".$_FILES["monfichier"]["tmp_name"].
                " a été déplacé vers ".$repertoireDestination.$nomDestination;
    } else {
        echo "Le fichier n'a pas été uploadé (trop gros ?) ou ".
                "Le déplacement du fichier temporaire a échoué".
                " vérifiez l'existence du répertoire ".$repertoireDestination;
    }
}
?>

*/