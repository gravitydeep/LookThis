        <!-- +++++++++++++++++++++++++++++++++++++++Formulaire d'ajout d'article+++++++++++++++++++++++++++++++++++++++ -->
        <div id="addArticleForm"  class="container-fluid h-100 p-0">
                    

            <div class="row h-100">                

                <div class="d-flex align-items-center justify-content-center col-12 h-100">

                    <div class="card bg-transparent w-50 h-100">
                        <div class="fw-bold mt-5 mb-5">
                            <h2><?=$title1 ?? ''?></h2>

                            <!-- ++++++++++++++++++++Message personnalisé+++++++++++++++++++++++++++++ -->

                            <?php 
                                if(!empty($msgCode) || $msgCode = trim(filter_input(INPUT_GET, 'msgCode', FILTER_SANITIZE_STRING))) 
                                {
                                    if(!array_key_exists($msgCode, $displayMsg))
                                    {
                                        $msgCode = 0;
                                    }
                                    echo '<div class="fs-3 alert '.$displayMsg[$msgCode]['type'].'">'.$displayMsg[$msgCode]['msg'].'</div>';
                                }
                            ?>
                        </div>

                        <div class="card-body h-100">
                            <form class="needs-validation" action="<?=htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">


                                <!-- =============================boucle choix catégories====================== -->

                                <select name="categories" id="categories" class="bg-transparent text-info form-control tex-info">
                                    <option value="">Choix de la catégorie</option>

                                    <?php foreach ($arrayCategories as $categoriesInSelect) {
                                        $isSelected = ($categoriesInSelect==$categories) ? 'selected': '';
                                        echo "<option value=\"$categoriesInSelect\" $isSelected>$categoriesInSelect</option>";
                                    }?>

                                </select>
                                <div class="invalid-feedback-2"><?= htmlentities($errorsArray['categories'] ?? '')?></div>

                                <!-- ==============================Titre=============================== -->

                                <div class="mb-3 mt-3">
                                    <input type="text" 
                                            name="title" 
                                            id="title" 
                                            class="bg-transparent form-control text-info"
                                            value="Saisir le titre de l'article">
                                </div>
                                <div class="invalid-feedback-2"><?= htmlentities($errorsArray['title'] ?? '')?></div>


                                    <!-- ============================Article============================== -->
                                <div class="mb-3">
                                    <label for="article" class="col-form-label text-info">Ecrire l' article</label>
                                    
                                    <textarea
                                        name ="article" 
                                        class="bg-transparent form-control text-info" 
                                        id="article" 
                                        rows="9" 
                                        minlength="10" 
                                        maxlength="1500"
                                        placeholder="Votre article">
                                    </textarea>
                                </div>
                                <div class="invalid-feedback-2"><?= htmlentities($errorsArray['article'] ?? '')?></div>


                                <button type="submit" class="card-header btn btn-warning rounded-pill w-100">Enregistrer l'article</button>
                                <div class="w-100">
                                <a class="border text-info btn btn-success mt-2" href="/../../admin/controllers/list-article-ctrl.php">Retour à la liste
                                des articles</a>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        