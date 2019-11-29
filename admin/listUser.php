<?php
/* ouverture de la session - création du coocky */
session_start();

/* Inclusion des librairies nécessaires */
include('../config/config.php');
include('../librairies/db.lib.php');
include('models/modelUser.php');

/* si la session n'est pas ouverte en tant qu'administrateur */
if ( !isConnected(ROLE_ADMIN) )
    header("Location: index.php"); /* Redirection vers la page de garde */

$title = "Liste des utilisateurs";
$view = 'listUser';

try {

    /* connexion à la base de données */
    $dbh = connexion();

    /* lecture des utilisateurs en BDD */
    $users = listUsers($dbh);

} catch (PDOException $e) {
    print "Erreur !: " . $e->getMessage() . "<br/>";
    die();
}

$userConnect = connectedUser($_SESSION);

include('tpl/layout.phtml');
