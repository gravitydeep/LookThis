<!-- +++++++++++++++++++++++++++++++++++++++Formulaire d'ajout d'article+++++++++++++++++++++++++++++++++++++++ -->
<div id="addArticleForm"  class="container-fluid h-100 p-0">
    <div class="row h-100">
        <div class="col-12 d-flex justify-content-end login-wrap p-0 h-100">
            <div class="d-flex flex-column align-items-center justify-content-center col-12 h-100">
                <div class="d-flex">
                    <h2 class=""><?=$title1 ?? ''?></h2>
                </div>
                
                        <!-- Affichage d'un message d'erreur personnalisé -->
                        <?php 

                        if(!empty($msgCode) || $msgCode = trim(filter_input(INPUT_GET, 'msgCode', FILTER_SANITIZE_STRING))) {
                            if(!array_key_exists($msgCode, $displayMsg)){
                                $msgCode = 0;
                            }
                            echo '<div class="fs-3 d-flex justify-content-center align-items-center alert '.$displayMsg[$msgCode]['type'].'">'.$displayMsg[$msgCode]['msg'].'</div>';
                        } 

                        ?>

                <div class="col-12 col-lg-6">
                    <form class="needs-validation" action="<?=htmlspecialchars($_SERVER['PHP_SELF']). "?id=" . $id?>" method="post">

                        <!-- ===========================Status commentaire========================== -->

                        <div class="form-outline">
                            <label for="state" class="col-form-label text-info"></label>

                            <?php
                                    if ($commentInfo->state == 0) {                    
                                ?>

                                        <div class='card-text text-danger text-start me-1'>Status du commentaire > <strong>DÉSACTIVÉ</strong>
                                        </div>

                                <?php } else { ?>

                                        <div class='card-text text-success text-start me-1'>Status du commentaire > <strong>ACTIVÉ</strong>
                                        </div>
                            
                                <?php } ?>

                        </div>

                        <div class="form-group mt-3">
                            <label for="state" class="col-form-label text-info">Désactiver/Activer le commentaire ?</label>

                            <select name="state" class="form-outline" required>
                                <option selected value="<?= htmlentities($state ?? '') ?>">Options</option>

                                <option value="0">Désactiver</option>
                                <option value="1">Activer</option>
                            </select>
                        </div>

                        <!-- =============================Catégories====================== -->

                            <select name="categories" 
                                    id="categories" 
                                    class="text-info bg-transparent form-control mb-2" 
                                    value="<?=htmlentities($categories ?? '')?>" required>

                                    <option><?= 'Categories'.' '.'>'.' '. htmlentities($categories ?? '')?></option>

                                    <?php foreach ($arrayCategories as $categoriesInSelect) {
                                $isSelected = ($categoriesInSelect==$categories) ? 'selected': '';
                                echo "<option value=\"$categoriesInSelect\" $isSelected>$categoriesInSelect</option>";}?>
                            </select>

                            <div class="invalid-feedback-2"><?= htmlentities($errorsArray['categories'] ?? '')?></div>

                            <!-- ============================Commentaire============================== -->
                        <div class="mb-3">
                            <label for="comment" class="col-form-label text-warning">Contenu du commentaire*</label>
                            
                            <textarea
                                
                                name ="comment" 
                                class="form-control bg-transparent text-info" 
                                id="comment" 
                                minlength="10" 
                                maxlength="1500"
                                rows="15"><?= htmlentities($comment ?? '');?> 
                            </textarea>
                        </div>
                        <div class="invalid-feedback-2"><?= htmlentities($errorsArray['comment'] ?? '')?></div>


                        <button type="submit" class="card-header btn btn-warning rounded-pill w-100">Mettre à jour</button>
                    </form>

                    <div class="d-flex flex-row justify-content-between">
                        <a class="btn btn-success mt-2 rounded-pill" href="/../../admin/controllers/add-comment-ctrl.php">Ajouter
                        un commentaire</a>

                        <a class="btn btn-success mt-2 rounded-pill text-end" href="/../../admin/controllers/list-comment-ctrl.php">Retour à la liste
                        des commentaires</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
            
<!-- *********************************************** -->
<script src="/../../assets/js/checkConfirm.js"></script>