<?php
session_start();
require_once dirname(__FILE__) . '/../../models/User.php';//Models
require_once(dirname(__FILE__).'/../../config/config.php');//Constante + gestion erreur

if (!isset($_SESSION['user'])) {
    header('Location: /../../controllers/signIn-ctrl.php?msgCode=30'); 
    die;
}

if($_SESSION['user']->email == DEFAULT_EMAIL && $_SESSION['user']->password == DEFAULT_PASSWORD) {
    header('Location: /../../controllers/signIn-ctrl.php?msgCode=30'); 
    die;
}

$title = 'Consultation d\'un profil utilisateur en cours ...';


// Nettoyage de l'id passé en GET dans l'url
$id = intval(trim(filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT)));

// Appel à la méthode statique permettant de récupérer tous les infos d'un seul utilisateur
$user = User::get($id);


// Si l'utilisateur n'existe pas, on redirige vers la liste complète avec un code erreur
if(!$user){
    header('location: /../admin/controllers/list-user-ctrl.php?msgCode=3');
}

/* ************* AFFICHAGE DES VUES **************************/

require dirname(__FILE__) . '/../../views/templates/header.php';
require dirname(__FILE__) . '/../../admin/views/display-user.php';
//require dirname(__FILE__) . '/../../admin/views/list-comment.php';

