<?php
    $title = "Photo4You | Admin";
    include_once("./includes/connection.inc.php");
    if($_SESSION['type'] != "admin") { header('Location: index.php'); }
    
    if(isset($_POST['valider'])) {
        $nom = htmlspecialchars($_POST['nom']);
        $libelle = htmlspecialchars($_POST['libelle']);

        $categorie = new Categorie(['Nom' => ucfirst($nom), 'Libelle' => $libelle]);
        $managerCategorie->add($categorie);
        header('Location: categories.php?error=add&nom='.$nom);
    }

    if(isset($_GET['delete'])) {
        $id = htmlspecialchars($_GET['delete']);
        $nom = htmlspecialchars($_GET['nom']);
        $managerCategorie->delete($id);

        header('Location: categories.php?error=delete&nom='.$nom);
    }

    include_once("./includes/header.inc.php");
    echo generationEntete("Photo4You", "Gérer les ".$managerCategorie->countCategories()." catégories.");
?>
    <div class="container">
        <?php
            if(isset($_GET['error'])) {
                $err = htmlspecialchars($_GET['error']);
                switch($err) {
                case 'add':
                    ?>
                        <div class="alert alert-success text-center">
                            <strong><i class="fa-regular fa-circle-check"></i> Succès :</strong> La catégorie <strong><?=htmlspecialchars($_GET['nom'])?></strong> viens d'etre ajoutée.
                        </div>
                    <?php
                    break;

                case 'update':
                    ?>
                        <div class="alert alert-success text-center">
                            <strong><i class="fa-regular fa-circle-check"></i> Succès :</strong> La catégorie <strong><?=htmlspecialchars($_GET['nom'])?></strong> viens d'etre modifiée.
                        </div>
                    <?php
                    break;
                
                case 'delete':
                    ?>
                        <div class="alert alert-danger text-center">
                            <strong><i class="fas fa-times-circle"></i> Attention :</strong> La catégorie <strong><?=htmlspecialchars($_GET['nom'])?></strong> viens d'etre supprimée.
                        </div>
                    <?php
                    break;

                default:
                    break;
                }
            }
        ?>

        <form class="row needs-validation" action="categories.php" method="POST" novalidate>
            <div class="row mb-3">
                <div class="col-lg-4 col-sm-12">
                    <label for="nom" class="form-label fw-bolder text-changing text-decoration-underline">Nom de la Catégorie :</label>
                    <input type="text" class="form-control"  id="nom" name="nom" required autofocus>
                </div>
                <div class="col-lg-8 col-sm-12">
                    <label for="libelle" class="form-label fw-bolder text-changing text-decoration-underline">Libéllé :</label>
                    <textarea class="form-control" id="libelle" name="libelle"></textarea>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col text-center">
                    <input type="submit" value="Valider" class="btn btn-primary" name="valider" />
                </div>
            </div>
        </form>

        <div class="input-group">
            <span class="input-group-text">Rechercher une catégorie</span>
            <input type="text" class="form-control" id="myInput" onkeyup="searchShortcut()" placeholder="Rechercher une catégorie...">
        </div>
        <table class="table table-striped table-hover text-center table-light">
            <thead>
                <tr>
                    <th scope="col" class="text-decoration-underline">ID</th>
                    <th scope="col" class="text-decoration-underline">Intitulé</th>
                    <th scope="col" class="text-decoration-underline">Libelle</th>
                    <th scope="col" class="text-decoration-underline">Action</th>
                </tr>
            </thead>
            <tbody id="racourci-container">
                <?php
                    foreach ($managerCategorie->getList() as $categorie):
                ?>
                <tr class='racourci'>
                    <td class='racourci-title'><?=$categorie['Id']?></td>
                    <td class='racourci-title'><?=$categorie['Nom']?></td>
                    <td class='racourci-title'><?=$categorie['Libelle']?></td>
                    <td class='racourci-title'>
                        <a title="Supprimer cette catégorie" class="btn btn-danger" href="./categories.php?delete=<?=$categorie['Id']?>&nom=<?=$categorie['Nom']?>" role="button"><i class="fa-solid fa-circle-xmark"></i></a>
                        <a title="Modifier cette catégorie" class="btn btn-warning" href="./modifier-categorie.php?id=<?=$categorie['Id']?>" role="button"><i class="fa-solid fa-pencil"></i></a>
                    </td>
                </tr>
                <?php
                    endforeach;
                ?>

                <tr id='noresult' style="display: none;">
                    <td colspan='5' class="fw-bolder bg-warning">Aucun résultat</td>
                </tr>
            </tbody>
        </table>
    </div>
<?php
    include_once("./includes/footer.inc.php");
?>