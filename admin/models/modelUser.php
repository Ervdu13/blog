<?php

/** insertion d'un usager
 * @param object PDO connexion
 * @param array $user informations à écrire
 * 
 * @return void
 * 
 */
function insertUser($dbh, $user) {
    /* On prépare notre requête */
    $sql = 'INSERT INTO users ( 
            username,
            email,
            password,
            firstname,
            lastname,
            bio,
            created_date,
            role,
            avatar)
        VALUES (
            :username,
            :email,
            :password,
            :firstname,
            :lastname,
            :bio,
            :created,
            :role,
            :avatar )';

    /* préparation de la requête */
    $stmt = $dbh->prepare($sql);

    /* Lier les paramètres externes / Binder*/
    $stmt->bindValue('username', $user[CONST_USER]);
    $stmt->bindValue('email', $user[CONST_MAIL]);
    $stmt->bindValue('password', password_hash($user[CONST_PWD], PASSWORD_DEFAULT));
    $stmt->bindValue('firstname', $user[CONST_F_NAME]);
    $stmt->bindValue('lastname', $user[CONST_L_NAME]);
    $stmt->bindValue('bio', $user[CONST_BIO]);
    $stmt->bindValue('created', date('Y-m-d H:i:s'));
    $stmt->bindValue('role', $user[CONST_ROLE]);
    $stmt->bindValue('avatar', $user[CONST_AVATAR]);

    /* Exécute la requête */
    $stmt->execute();
}

/** lecture informations de l'usager à partir de son adresse mail
 * 
 * @param object PDO connexion
 * @param string $email email utilisateur
 * 
 * @return array Tableau jeu d'enregistrement
 * 
 * */
function readUser($dbh, $email) {
    $sql = 'SELECT *  
            FROM users
            WHERE email = :email';

    /* préparation de la requête */
    $stmt = $dbh->prepare($sql);

    /* Lier les paramètres externes / Binder*/
    $stmt->bindValue('email', $email);

    /* Exécute la requête */
    $stmt->execute();

    /* Retourne le jeu d'enregistrement */
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/** Vérification de la connexion avec le bon role
 * 
 * @param string $role role que doit avoir l'utilisateur
 * 
 * @return boolean vrai si l'utilisateur connecté a le droit d'accéder à cette page, sinon redirection
 */
function isConnected($role) {

    /* si non connecté */
    if (!isset($_SESSION['connected']) || !$_SESSION['connected']) 
    {
        header("Location: login.php"); /* Redirection vers le login */
    } else if ($_SESSION['role'] == $role)
        return true;

    return false;
}

/** Mise à jour de la date de login
 *
 * @param object PDO connexion
 * @param string $email mail de connexion de l'utilisateur
 * 
 * @return void
 */
function updateLastLoginUser($dbh , $email) {

    $sql = 'UPDATE users
            SET last_login = :date
            WHERE email = :email'; 

    /* préparation de la requête */
    $stmt = $dbh->prepare($sql);

    /* Lier les paramètres externes / Binder*/
    $stmt->bindValue('email', $email);
    $stmt->bindValue('date', date('Y-m-d H:i:s'));

    /* Exécute la requête */
    $stmt->execute();
}

/** Liste de tous les utilisateurs
 * 
 * @param object PDO connexion
 * 
 * @return array Tableau jeu d'enregistrement
 */
function listUsers($dbh) {
    $sql = 'SELECT *  
            FROM users
            ORDER BY role ASC';

    /* préparation de la requête */
    $stmt = $dbh->prepare($sql);

    /* Exécute la requête */
    $stmt->execute();

    /* Retourne le jeu d'enregistrement */
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/** formate la chaine de caractère pour afficher l'utilisateur connecté
 * 
 * @param array $user information sur l'utilisateur
 * 
 * @return string chaine formatée
 */
function connectedUser($user) {

    $connectedUser = '';

    if (!isset($_SESSION['connected']) || !$_SESSION['connected']) 
    {
        $connectedUser = 'utilisateur non connecté';
    }
    else
    {
        switch ($user['role'])
        {
            case ROLE_ADMIN :
                $connectedUser = 'Administrateur : '; 
                break;

            case ROLE_AUTHOR :
                $connectedUser = 'Auteur : '; 
            break;

            case ROLE_USER :
                $connectedUser = 'Utilisateur : '; 
            break;
        }

        $connectedUser = $connectedUser . $user['lastname'] . ' ' . $user['firstname'] . ' connecté';
    }

    return $connectedUser;
}

/** Vérifie l'inicité du username et du password
 * 
 * @param object PDO connexion
 * @param string $username pseudo
 * @param string $email adresse mail
 * 
 * @return int numéro d'erreur - 0 = Ok
 * 
 */
function verifUniq($dbh, $username, $email) {

    $sql1 = 'SELECT count(*) FROM users WHERE email = :email';
    $sql2 = 'SELECT count(*) FROM users WHERE username = :username';

    /* gestion de la requête 1*/
    $stmt = $dbh->prepare($sql1);
    $stmt->bindValue('email', $email);
    $stmt->execute();
    $ret1 = $stmt->fetchAll(PDO::FETCH_ASSOC);

    /* gestion de la requête 2*/
    $stmt = $dbh->prepare($sql2);
    $stmt->bindValue('username', $username);
    $stmt->execute();
    $ret2 = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if ($ret1[0]['count(*)'] == '0' && $ret2[0]['count(*)'] == '0')
        return 0;
    else if ($ret1[0]['count(*)'] == '1' && $ret2[0]['count(*)'] == '1')
        return CONST_CODE_ERR_USER_MAIL;
    else if ($ret1[0]['count(*)'] == '1')
        return CONST_CODE_ERR_MAIL;
    else
        return CONST_CODE_ERR_USER;

}
