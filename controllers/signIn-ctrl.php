<?php
session_start();
require_once dirname(__FILE__).'/../models/User.php';//Models
require_once dirname(__FILE__).'/../config/config.php';//Gestion erreur + constante


$errorsArray = array();//Tableau erreur vide

$title = 'Connexion';


if($_SERVER['REQUEST_METHOD'] == 'POST') // On controle le type(post) que si il y a des données d'envoyées 
{ 

    // ********************************Email*************************************
    $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL)); // On nettoie

    if(!empty($email)) // On test si le champ n'est pas vide
    {
        $testEmail = filter_var($email, FILTER_VALIDATE_EMAIL); // On test la valeur

        if(!$testEmail)
        {    
            $errorsArray['email'] = 'L\'email n\'est pas valide';
        }

    }else{
        $errorsArray['email'] = 'Le champ est obligatoire';
    }

    // **************************Password**************************
    $password =  $_POST['password'];
        
    if(!empty($password)) // On test si le champ n'est pas vide
    {

            // Si aucune erreur, on enregistre en BDD
        if(empty($errorsArray))
        {
            $user = User::getByEmail($email);//On check si l'utilisateur exite
            
            if($user)//Si vrai = true 1
            {


                $pseudo = $user->pseudo ;
                $email = $user->email ;
                $state = $user->state ;

            

                $isPasswordOk = password_verify($password, $user->password);//On vérifie le mdp
                if($isPasswordOk)//Si mdp est le meme que celui en bdd
                {

                    // **************************Cookie******************************

                    //Si cookie vide/n'existe pas/expiré on le génère 
                    if (empty($_COOKIE['cookie-email']) && empty($_COOKIE['cookie-pseudo']) && empty($_COOKIE['cookie-state']))
                    {

                        //Les infos du cookie stocker chez l'utilisateur peuvent etre modifier donc on nettoie

                        setcookie('cookie-email', $email, array(

                            'expires' => time() + 60*24*36000,//Valide 1 an

                            'secure' => false, //Si true cookie uniquement transmis à travers une connexion sécurisée HTTPS depuis le client.$_SERVER['https']

                            'httponly' => true, //Si true, le cookie ne sera accessible que par le protocole HTTP. 
                            //Cela signifie que le cookie ne sera pas accessible via des langages de scripts, comme Javascript. 
                            //Il a été suggéré que cette configuration permet de limiter les attaques via XSS 
                            //bien qu'elle ne soit pas supportée par tous les navigateurs), néanmoins ce fait est souvent contesté. true ou false

                            'samesite' => 'lax'//valeur par défaut pour une meilleure défense contre les attaques de type cross-site request forgery (CSRF).
                            ));

                        setcookie('cookie-pseudo', $pseudo , array(
                            'expires' => time() + 60*24*36000,
                            'secure' => false,
                            'httponly' => true,
                            'samesite' => 'lax'
                            ));

                        setcookie('cookie-state', $state , array(
                            'expires' => time() + 60*24*36000,
                            'secure' => false,
                            'httponly' => true,
                            'samesite' => 'lax'
                            ));

                    }
                    // **********************************************************************

                    $_SESSION['user'] = $user;//On crée la session
                    
                    // **********************Connection administration**********************

                    //On check si le mdp par défault est le meme que le mdp en bdd
                    $passDefault =  password_verify(DEFAULT_PASS, $user->password);

                    if($user->email == DEFAULT_EMAIL && $passDefault == DEFAULT_PASS) 
                    {
                        header('location: /../admin/controllers/list-user-ctrl.php');//On redirige l'admin vers la liste des utilisateurs
                        die;        

                    }else {
                        //On connecte l'utilisateur
                        header('location: /../controllers/landing-ctrl.php');//On redirige l'utilisateur vers son tableau de bord
                        die;
                    }



                }else {
                    $errorsArray['password'] = 'Le mot de passe est incorrect';
                }
        
            }else {
                header('location: /../controllers/signIn-ctrl.php?msgCode=19');//si le compte existe déjà on redirige av mess erreur
                die;
            }

        }

    }else{
        $errorsArray['password'] = 'Le champ est obligatoire';
    }

}

// **************************VUES***************************
require_once dirname(__FILE__).'/../views/templates/header.php';
require_once dirname(__FILE__).'/../views/user/signIn.php';
require_once dirname(__FILE__).'/../views/templates/footer.php';