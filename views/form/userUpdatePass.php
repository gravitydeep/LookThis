<?php
if (empty(session_id())){
    session_start(); // Démarrage de la session  
}       
//require_once __DIR__.'/../../views/templates/navbar.php';
//require_once __DIR__.'/../models/User.php';//models
//require_once __DIR__.'/../../utils/config.php';//Gestion erreur
?>

<!-- ======================================CHANGER MOT DE PASSE=================================== -->
<div id="landingSpace" class="container-fluid h-100">
    <div class="row justify-content-center h-100">
        <h2 class="d-flex justify-content-center align-items-center">Modifier mon mot de passe</h2>

        <div class="col-lg-4 p-0">
                
                <?php 
                    if(!empty($msgCode) || $msgCode = trim(filter_input(INPUT_GET, 'msgCode', FILTER_SANITIZE_STRING))) 
                    {
                        if(!array_key_exists($msgCode, $displayMsg))
                        {
                            $msgCode = 0;
                        }
                        echo '<div class="alert '.$displayMsg[$msgCode]['type'].'">'.$displayMsg[$msgCode]['msg'].'</div>';
                    }
                ?>

            <form action="<?=htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST">
                <div class="mb-3">
                    <label for='current_password' class="text-warning">Mot de passe actuel*</label>                       
                    <input type="password" id="current_password" name="current_password"
                        class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for='new_password' class="text-warning">Nouveau mot de passe*</label>
                    <input type="password" id="new_password" name="new_password" class="form-control"
                        required>
                </div>

                <div class="mb-3">
                    <label for='new_password_retype' class="text-warning">Confirmer le nouveau mot de passe*</label>
                    <input type="password" id="new_password_retype" name="new_password_retype"
                        class="form-control" required>
                    <button type="submit" class="btn btn-success mt-2">Sauvegarder</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
require_once __DIR__.'/../../views/templates/footer.php';
?>