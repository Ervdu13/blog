<?php


function connexion()
{
    $dbh = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', DB_USER, DB_PASS);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbh;
}

