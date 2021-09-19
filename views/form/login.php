<!-- ============================Formulaire connexion====================== -->

    <div id="signInForm" class="container-fluid">
        <div class="row justify-content-center align-items-center h-100">
            <div class="d-flex flex-column col-12 col-lg-4">
                <h2 class="mt-5"><?=$title ?? ''?></h2>
                <div class="login-wrap">

                <!-- Affichage d'un message d'erreur personnalisé -->
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
                <!-- -------------------------------------------- -->


                    <form action="<?=htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">

                        <div class="form-outline">
                            <input type="email" 
                                    name="email" 
                                    class="form-control" 
                                    id="email" 
                                    placeholder="Adresse e-mail" 
                                    autocomplete="email"
                                    value="<?= htmlentities($_POST['email'] ?? '')?>" 'required>
                            <label for="email" class="col-form-label text-warning">Adresse Email*</label>

                            <div class="valid-feedback">Parfait!</div>
                            <div class="invalid-feedback">Merci de choisir un email valide.</div>
                        </div>
                        <div class="invalid-feedback-2"><?= htmlentities($errorsArray['email'] ?? '')?></div>


                        <div class="form-outline mt-3">
                            <input type="password" 
                                    name="password" 
                                    class="form-control" 
                                    id="password" 
                                    placeholder="Votre mot de passe" 
                                    autocomplete="off" 
                                    minlength="8" 
                                    maxlength="20" 
                                    value="<?= htmlentities($_POST['password'] ?? '')?>" 'required>
                            <label for="password" class="col-form-label text-warning">Mot de passe*</label>
                        </div>
                        <div class='invalid-feedback-2' id='errPass1'><?=htmlentities($errorsArray['password'] ?? '')?></div>


                        <div class="form-outline mt-3">
                            <button id="btnSubmit" 
                                    type="submit" 
                                    class="form-control btn btn-outline-warning submit px-3 rounded-pill">Se connecter</button>
                        </div>

                        <div class="form-outline d-md-flex mt-2">
                            <div class="">
                                <a class="text-decoration-none text-warning" href="/../controllers/findPassword-ctrl.php" >Mot de passe oublié?</a>
                            </div>
                        </div>

                        <div class="form-outline d-md-flex mt-2">
                            <div class="">
                                <a class="text-decoration-none text-warning" href="/../controllers/register-ctrl.php" >S'inscrire?</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


