<?php
session_start();
require_once(dirname(__FILE__).'/../../admin/utils/regex.php');
require_once(dirname(__FILE__).'/../../admin/models/User.php');//Models
require_once(dirname(__FILE__).'/../../admin/config/config.php');//Constante + Gestion erreur

// Initialisation du tableau d'erreurs
$errorsArray = array();

$title = 'Inscription';

// ================================================================================
if($_SERVER['REQUEST_METHOD'] == 'POST') // On controle le type(post) que si il y a des données d'envoyées 
{ 
    
     // ************************pseudo************************
    
    // On verifie l'existance et on nettoie
    $pseudo = trim(filter_input(INPUT_POST, 'pseudo', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));

    //On test si le champ n'est pas vide
    if(!empty($pseudo)){
        // On test la valeur
        $testRegex = preg_match('/'.REGEX_PSEUDO.'/',$pseudo);

        if(!$testRegex){
            $errorsArray['pseudo'] = 'Merci de choisir un pseudo valide';
        }
    }else{
        $errorsArray['pseudo'] = 'Le champ est obligatoire';
    }

    // **********************Email******************************
    
    // On verifie l'existance et on nettoie
    $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
    $email2 = trim(filter_input(INPUT_POST, 'email2', FILTER_SANITIZE_EMAIL));

    //On test si le champ n'est pas vide
    if(!empty($email) && !empty($email2))
    {
        // On test la valeur
        $testMail = filter_var($email, FILTER_VALIDATE_EMAIL);
        $testMail2 = filter_var($email2, FILTER_VALIDATE_EMAIL);

        if(!$testMail || !$testMail2){
            $errorsArray['email'] = 'Le mail n\'est pas valide';
            $errorsArray['email2'] = 'Le mail n\'est pas valide';
        }

    }else{
        $errorsArray['email'] = 'Le champ est obligatoire';
        $errorsArray['email2'] = 'Le champ est obligatoire';
    }
    // ***********************Password***************************

    $password = $_POST['password'];
    $password2 = $_POST['password2'];

    //On test si le champ n'est pas vide
    if(!empty($password) && !empty($password2))
    {

        if($password!=$password2){
            $errorsArray['password'] = 'Les mots de passe sont différents';
            $errorsArray['password2'] = 'Les mots de passe sont différents';
        } else {
            $cost =['cost' => 12]; // On hash le mot de passe avec Bcrypt, via un coût de 12
            $password = password_hash($password, PASSWORD_DEFAULT,$cost);
        }

    }else{
        $errorsArray['password'] = 'Le champ est obligatoire';
        $errorsArray['password2'] = 'Le champ est obligatoire';
    }

    // Si aucune erreur, on enregistre en BDD
    if(empty($errorsArray))
    {
        // ON invoque la méthode statique permettant de vérifier si l'utilisateur existe si non ok (grâce a son email)
        $checkUser = User::getByEmailUser($email);

        $ip = $_SERVER['REMOTE_ADDR'];// On stock l'adresse IP 

        $user = new User($pseudo, $email, $password, $ip);//On instancie/On récupére les infos

        if(!$checkUser)//Si l'utilisateur n'existe pas c'est ok
        {

            // **************************Cookie******************************
            //Si les cookies n'existent pas
            if (empty($_COOKIE['cookie-email']) && empty($_COOKIE['cookie-pseudo']) && empty($_COOKIE['cookie-state'])) 
            {
                //On genere le cookie
                setcookie('cookie-email', $email, array(

                    'expires' => time() + 60*24*36000,//Valide 1 an
                    'path' => '/',
                    'domain' => '',
                    'secure' => false, //Si true cookie uniquement transmis à travers une connexion sécurisée HTTPS depuis le client.Voir $_SERVER['https']

                    'httponly' => true, //Si true, le cookie ne sera accessible que par le protocole HTTP. 
                    //Cela signifie que le cookie ne sera pas accessible via des langages de scripts, comme Javascript. 
                    //Il a été suggéré que cette configuration permet de limiter les attaques via XSS 
                    //bien qu'elle ne soit pas supportée par tous les navigateurs), néanmoins ce fait est souvent contesté. true ou false

                    'samesite' => 'lax'//valeur par défaut pour une meilleure défense contre les attaques de type cross-site request forgery (CSRF).
                    ));

                setcookie('cookie-pseudo', $pseudo , array(//Valeur cookie deja sécurisé/nettoyé
                    'expires' => time() + 60*24*36000,
                    'path' => '/',
                    'domain' => '',
                    'secure' => false,
                    'httponly' => true,
                    'samesite' => 'lax'
                    ));

                setcookie('cookie-state', $state , array(
                    'expires' => time() + 60*24*36000,
                    'path' => '/',
                    'domain' => '',
                    'secure' => false,
                    'httponly' => true,
                    'samesite' => 'lax'
                    ));
            }

            // **************************************************************
            $result = $user->createUser();//On ajoute l'utilisateur en bdd
            
            if($result===true){//Si l'ajout s'est bien passé = 1

                header('location: /../../user/controllers/signIn-ctrl.php?msgCode=12');//On redirige av mess succés
                die;
            
            } else {
                // Si l'enregistrement s'est mal passé, on réaffiche le formulaire av un mess d'erreur.
                $msgCode = $result;
            }

        }else {
            header('location: /../../user/controllers/signUp-ctrl.php?msgCode=13');//Si l'utilisateur existe on redirige av mess erreur
            die;
        }

    }
    
}

// **********************VUES******************************
require_once(dirname(__FILE__).'/../../templates/header.php');
require_once(dirname(__FILE__).'/../../user/views/signUp.php');
require_once(dirname(__FILE__).'/../../templates/footer.php');
