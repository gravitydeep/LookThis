<?php
session_start();
require_once dirname(__FILE__) . '/../../admin/models/Comment.php';//Models
require_once(dirname(__FILE__).'/../../admin/config/config.php');//Constante + gestion erreur

// *****************************************SECURITE ACCES PAGE******************************************
if (!isset($_SESSION['user'])) {
    header('Location: /../../user/controllers/signIn-ctrl.php?msgCode=30'); 
    die;
}

//On check si le mdp par défault est le meme que le mdp en cours
$passDefault =  password_verify(DEFAULT_PASS, $_SESSION['user']->password);

if($_SESSION['user']->email != DEFAULT_EMAIL && $passDefault != DEFAULT_PASS) {
    header('Location: /../../user/controllers/signIn-ctrl.php?msgCode=30'); 
    die;
        
}
// ********************************************************************************************************

$title1 = 'Consultation d\'un commentaire en cours ...';

//**************************ID******************************
// On verifie l'existance et on nettoie
$id = intval(trim(filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT)));

// Appel à la méthode statique permettant de récupérer tous les infos d'un seul commentaire
$commentInfo = Comment::getComment($id);

// Si le commentaire n'existe pas, on redirige vers la liste complète avec un code erreur
if(!$commentInfo){
    header('location: /../admin/controllers/list-comment-ctrl.php?msgCode=8');
}

/* ************* AFFICHAGE DES VUES **************************/

require_once dirname(__FILE__) . '/../../templates/header.php';
require_once dirname(__FILE__) . '/../../admin/views/display-comment.php';

