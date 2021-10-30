<!-- *************************************Formulaire ajout commentaire*************************************** -->
<?php
session_start(); // Démarrage de la session  
require_once(dirname(__FILE__).'/../models/Comment.php');//models
require_once(dirname(__FILE__).'/../models/User.php');//models
require_once(dirname(__FILE__).'/../config/config.php');//Constante + gestion erreur

// *****************************************SECURITE ACCES PAGE******************************************
if (!isset($_SESSION['user'])) {
    header('Location: /../../controllers/signIn-ctrl.php?msgCode=30'); 
    die;
}
// ********************************************************************************************************

// Initialisation du tableau d'erreurs
$errorsArray = array();

//tabeau (boucle front) choix catégories
$arrayCategories = ['web','réseau','humaine','applicative'];

$title1 = 'Commenter un article';

// Nettoyage de l'id passé en GET dans l'url
$id = intval(trim(filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT)));


// ********************************************************************************************************
if($_SERVER['REQUEST_METHOD'] == 'POST') // On controle le type(post) que si il y a des données d'envoyées 
{ 

    //**************************Categories*************************

    // On verifie l'existance et on nettoie
    $categories = trim(filter_input(INPUT_POST, 'categories', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));

    //**************************Commentaire************************

    // On verifie l'existance et on nettoie
    $comment = trim(filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));

    //**************************Status******************************

    // On verifie l'existance et on nettoie
    $state = intval(trim(filter_input(INPUT_POST, 'state', FILTER_SANITIZE_NUMBER_INT)));


    //On test si le champ n'est pas vide
    if(empty($categories)){

        $errorsArray['categories'] = 'Le champ est obligatoire';
        
    }

    //On test si le champ n'est pas vide
    if(empty($comment)){
        
        $errorsArray['comment'] = 'Le champ est obligatoire';
        
    }

    if(empty($errorsArray))
    {
    
        $pdo = Database::db_connect();
        $pdo->beginTransaction();

        $id_comment = $_SESSION['user']->id;

        $getNewComment = new Comment($categories, $User, '', '', '',$id_comment);
        $createComment = $user->createComment();
        
        if($createComment === true){
            $pdo->commit(); // Valide la transaction et exécute toutes les requetes 

            header('location: /../../admin/controllers/list-comment-ctrl.php?msgCode=11');//On redirige av mess succés
            die;

        } else {
            $pdo->rollBack(); // Annulation de toutes les requêtes exécutées avant la levée de l'exception

                // Si l'enregistrement s'est mal passé, on redirige av un mess d'erreur.
                header('location: /../../admin/controllers/list-comment-ctrl.php?msgCode=46');
                die;
            }  

    }

}

// ********************************Vues****************************
require_once dirname(__FILE__).'/../views/templates/header.php';
require_once dirname(__FILE__).'/../views/user/add-comment.php';


