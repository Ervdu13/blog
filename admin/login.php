<?php

/* ouverture de la session - création du coocky */
session_start();

/* Inclusion des librairies nécessaires */
include('../config/config.php');
include('../librairies/db.lib.php');
include('models/modelUser.php');

$title = 'login';
$view = 'login';

$error = [];
$email = '';
$password = '';


/** On essai de se connecter au serveur et de faire des requêtes
 * PDO lève une exception en cas de problème de connexion ou de requête
 */
try {

    if(array_key_exists(CONST_MAIL,$_POST))
    {
        $email = $_POST[CONST_MAIL];
        $password = $_POST[CONST_PWD];

        /* recherche si les informations sont existantes dans la base */

        /* connexion à la base de données */
        $dbh = connexion();

        /* lecture en BDD */
        $user = readUser($dbh, $email);

        if ($user !== false && password_verify ( $password , $user[CONST_PWD] ) )
        {
            /* connection ok, création de la page de garde & affichage de la page de garde */
            $_SESSION['username'] = $user['username']; // met username dans le fichier coocky
            $_SESSION['connected'] = true;
            $_SESSION['role'] = $user['role'];
            $_SESSION['firstname'] = $user['firstname'];
            $_SESSION['lastname'] = $user['lastname'];

            /* mise à jour de la date du dernier login */
            updateLastLoginUser($dbh , $email);

            /* redirection vers la page index.html */
            header("Location: index.php"); /* Redirection du navigateur */
        }
        else
        {
            $_SESSION['connected'] = false;
            $_SESSION['username'] = '';
            $_SESSION['role'] = '';
            $_SESSION['firstname'] = '';
            $_SESSION['lastname'] = '';
        }     
        
    } else if(array_key_exists('unlog',$_GET))
    {
        $_SESSION['connected'] = false;
        $_SESSION['username'] = '';
        $_SESSION['role'] = '';
        $_SESSION['firstname'] = '';
        $_SESSION['lastname'] = '';

        $view = 'index';
    }
    

} catch (PDOException $e) {
    print "Erreur !: " . $e->getMessage() . "<br/>";
    die();
}

$userConnect = connectedUser($_SESSION);

include('tpl/layout.phtml');
