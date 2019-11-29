<?php
/* ouverture de la session - création du coocky */
session_start();

/* Inclusion des librairies nécessaires */
include('../config/config.php');
include('../librairies/db.lib.php');
include('../librairies/file.lib.php');
include('models/modelUser.php');
include('models/modelCateg.php');

/* si la session n'est pas ouverte en tant qu'administrateur */
if ( !isConnected(ROLE_ADMIN) )
    header("Location: index.php"); /* Redirection vers la page de garde */

$title = "Ajout d'une catégorie";
$view = 'addCateg';

$category = '';
$description = '';


$error = [];

/** On essai de se connecter au serveur et de faire des requêtes
 * PDO lève une exception en cas de problème de connexion ou de requête
 */
try {

    /* connexion à la base de données */
    $dbh = connexion();

    /* liste des catégories existantes */
    $categories = listCategories($dbh);

    if(array_key_exists('category',$_POST))
    {
        $name = $_POST['category'];
        $desription = $_POST['desc'];
        $order = $_POST['parentcateg'];
        $parentId = $_POST['order'];

        var_dump($_POST);

        //Vérification des valeurs saisies
        if (strlen($name) == 0)
            $error[] = CONST_ERR_CATEG;
        
        /* verification que le username et l'adresse mail ne sont pas déjà existants dans la base */
        if ( !verifUniqCateg($dbh, $name))
                $error[] = CONST_ERR_UNIQ_CATEG;

        /* si il n'y a pas d'erreurs */
        if (count($error) == 0)
        {
            /* ecriture en BDD */
            insertCateg($dbh, $_POST);

            $view = 'listCateg';
        }
    }
} catch (PDOException $e) {
    print "Erreur !: " . $e->getMessage() . "<br/>";
    die();
}


$userConnect = connectedUser($_SESSION);

include('tpl/layout.phtml');


