<?php
/* ouverture de la session - création du coocky */
session_start();

/* Inclusion des librairies nécessaires */
include('../config/config.php');
include('../librairies/db.lib.php');
include('../librairies/file.lib.php');
include('models/modelUser.php');

/* si la session n'est pas ouverte en tant qu'administrateur */
if ( !isConnected(ROLE_ADMIN) )
    header("Location: index.php"); /* Redirection vers la page de garde */

$title = "Ajout d'un utilisateur";
$view = 'addUser';


$username = '';
$email = '';
$password = '';
$firstname = '';
$lastname = '';
$bio = '';
$role = '';
$avatar = '';

$error = [];


/** On essai de se connecter au serveur et de faire des requêtes
 * PDO lève une exception en cas de problème de connexion ou de requête
 */
try {

    if(array_key_exists('username',$_POST))
    {
        $username = $_POST[CONST_USER];
        $email = $_POST[CONST_MAIL];
        $password = $_POST[CONST_PWD];
        $confPassword = $_POST[CONST_CONF_PWD];
        $firstname = $_POST[CONST_F_NAME];
        $lastname = $_POST[CONST_L_NAME];
        $bio = $_POST[CONST_BIO];
        $role = $_POST[CONST_ROLE];
        //$avatar = $_POST[CONST_AVATAR];

        //Vérification des valeurs saisies
        if (strlen($username) == 0)
            $error[] = CONST_ERR_USER;
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))     
            $error[] = CONST_ERR_MAIL;

        if (strlen($password) == 0)
            $error[] = CONST_ERR_PWD_EMPTY;
        else if (strcmp($password,$confPassword) != 0)
            $error[] = CONST_ERR_PWD_NO_CONF;

        if (strlen($role) == 0)
            $error[] = CONST_ERR_ROLE;

        /* connexion à la base de données */
        $dbh = connexion();

        /* verification que le username et l'adresse mail ne sont pas déjà existants dans la base */
        switch (verifUniq($dbh, $username, $email))
        {
            case CONST_CODE_ERR_MAIL : // le mail existe déjà
                $error[] = CONST_ERR_UNIQ_MAIL;
                break;
            case CONST_CODE_ERR_USER : // le username existe déjà
                $error[] = CONST_ERR_UNIQ_USER;
                break;
            case CONST_CODE_ERR_USER_MAIL : // le mail et le username existent déjà
                $error[] = CONST_ERR_UNIQ_MAIL_USER;
                break;
        }

        /* upload fichier avatar */
        uploadMyFile();

        /* si il y a des erreurs */
        if (count($error) != 0)
        {
            $password='';
        }
        else
        {
            /* ecriture en BDD */
            insertUser($dbh, $_POST);

            $view = 'listUser';
        }
    }
} catch (PDOException $e) {
    print "Erreur !: " . $e->getMessage() . "<br/>";
    die();
}

$userConnect = connectedUser($_SESSION);

include('tpl/layout.phtml');




