<?php
/* ouverture de la session - création du coocky */
session_start();

/* Inclusion des librairies nécessaires */
include('../config/config.php');
include('../librairies/db.lib.php');
include('models/modelUser.php');

$title = "Accueil";
$view = 'index';

$userConnect = connectedUser($_SESSION);

include('tpl/layout.phtml');
