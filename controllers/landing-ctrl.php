<?php
session_start(); // Démarrage de la session        
require_once __DIR__ .'/../utils/db.php'; // On inclut la connexion à la base de données

// Si la session n'existe pas 
if(!isset($_SESSION['user']))
{
    header('Location:/../views/form/login.php');
    die();
}

require_once __DIR__ .'/../views/templates/navbar.php';
require_once __DIR__ .'/../views/landing.php';
require_once __DIR__ .'/../views/templates/footer.php';