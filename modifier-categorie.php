<?php
    $title = "Photo4You | Admin";
    include_once("./includes/connection.inc.php");
    if($_SESSION['type'] != "admin") { header('Location: index.php'); }
    if(!isset($_GET['id'])) { header('Location: categories.php'); }
    
    $id = htmlspecialchars($_GET['id']);
    if(!$managerCategorie->exists($id)) { header('Location: categories.php'); }
    $categorie = $managerCategorie->getCategorie($id);

    if(isset($_POST['valider'])) {
        $categorie->setLibelle($_POST['libelle']);
        $categorie->setNom($_POST['nom']);
        $managerCategorie->update($categorie);

        header('Location: categories.php?error=update&nom='.$categorie->getNom());
    }

    include_once("./includes/header.inc.php");
    echo generationEntete("Photo4You", "Modifier la catégorie ".$categorie->getNom().".");
?>
    <div class="container">
        <form class="row needs-validation" action="./modifier-categorie.php?id=<?=$categorie->getId();?>" method="POST" novalidate>
            <div class="row mb-3">
                <div class="col-lg-4 col-sm-12">
                    <label for="nom" class="form-label text-decoration-underline">Nom de la Catégorie :</label>
                    <input type="text" class="form-control"  id="nom" name="nom" value="<?=$categorie->getNom();?>" required autofocus>
                </div>
                <div class="col-lg-8 col-sm-12">
                    <label for="libelle" class="text-decoration-underline">Libéllé :</label>
                    <textarea class="form-control" id="libelle" name="libelle"><?=$categorie->getLibelle();?></textarea>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col text-center">
                    <input type="submit" value="Valider" class="btn btn-primary" name="valider" />
                </div>
            </div>
        </form>
    </div>
<?php
    include_once("./includes/footer.inc.php");
?>