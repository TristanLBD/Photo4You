<?php
    $title = "Photo4You | Ventes";
    include_once("./includes/connection.inc.php");
    if($_SESSION['type'] != "photographe" && $_SESSION['type'] != "admin") { header('Location: index.php'); }
    if(!isset($_GET['id'])) { header('Location: mes-ventes.php'); }
    $idPhoto = htmlspecialchars($_GET['id']);
    
    if(!$photo = $managerPhoto->getPhotoById($idPhoto)) {header('Location: mes-ventes.php');}
    //! Si la photo à déja été publiée on redirige
    if($managerPhoto->isChecked($photo['Id'])) { header('Location: mes-ventes.php'); die(); }
    $categorieList = explode(", ",$photo['Categories']);
    
    if(isset($_POST['valider']) && isset($_POST['nom']) && isset($_POST['id']) && isset($_POST['description']) && isset($_POST['categories']) && isset($_POST['credits'])) {
        $nom = htmlspecialchars($_POST['nom']);
        $description = htmlspecialchars($_POST['description']);
        $credits = htmlspecialchars($_POST['credits']);
        $categories = $_POST['categories'];
        $idPhoto = htmlspecialchars($_POST['id']);

        //! On retire toutes les ancienens catégories de cette photo
        $managerAppartenir->delete($idPhoto);

        //! On remet les nouvelles catégories
        foreach ($categories as $row) {
            $appartenir = new Appartenir(['Photo' => $idPhoto, 'Categorie' => $row]);
            $managerAppartenir->add($appartenir);
        }
        
        $photo = new Photo(['Nom' => $nom,'Id' => $idPhoto, 'Description' => $description, 'Prix' => $credits]);
        $managerPhoto->update($photo);

        if(isset($_GET['admin']) && !empty($_GET["admin"])) {
            header('Location: validations.php?error=modified');
        } else {
            header('Location: mes-ventes.php?error=modified');
        }
    }

    include_once("./includes/header.inc.php");
    echo generationEntete("Photo4You", "Modifier une vente.");
?>
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-sm-12">
                <img src="./images/ventes/<?=$photo['Url']?>" alt="Votre Image" class="img-fluid rounded grow">
            </div>
            <div class="col-lg-8 col-sm-12">
                <form class="row needs-validation" action="modifier-ventes.php?id=<?=$_GET['id']?><?php if(isset($_GET['admin']) && !empty($_GET["admin"])){echo("&admin=admin");}?>" method="POST" novalidate>
                    <input type="text" name="id" id="id" class="form-control d-none" value="<?=$photo['Id']?>" required>
                    
                    <div class="col-12">
                        <label for="nom" class="form-label text-decoration-underline">Nom :</label>
                        <input type="text" name="nom" id="nom" class="form-control" value="<?=$photo['Nom']?>" required autofocus>
                        <div class="valid-feedback">Nom valide. <i class="fa-regular fa-circle-check"></i></div>
                        <div class="invalid-feedback">Nom invalide <i class="fa-solid fa-circle-xmark"></i></div>
                    </div>

                    <div class="col-12 mt-3">
                        <label for="description" class="text-decoration-underline">Description :</label>
                        <textarea required class="form-control" id="description" name="description"><?=$photo['description']?></textarea>
                        <div class="valid-feedback">Description valide. <i class="fa-regular fa-circle-check"></i></div>
                        <div class="invalid-feedback">Description invalide <i class="fa-solid fa-circle-xmark"></i></div>
                    </div>

                    <div class="col-12 mt-3">
                        <label for="credits" class="form-label text-decoration-underline">Nombre de crédits :</label>
                        <div class="input-group">
                            <input required onkeyup="changeMoneyInput(this.value*5,'sum')" type="number" min="0" pattern="[0-9]{6}" value="<?=$photo['Prix']?>" id="credits" name="credits" class="form-control fw-bolder" value="0">
                            <span class="input-group-text fw-bolder"><span id="sum"><?= number_format($photo['Prix']*5, 0, '.', ' ')?></span> €</span>
                        </div>
                    </div>

                    <div class="col-12 mt-3">
                        <label for="categories" class="form-label text-decoration-underline">Catégorie(s) :</label><br>
                        <select required name="categories[]" id="categories" multiple>
                            <?php foreach($managerCategorie->getList() as $categories): ?>
                                <option <?php if(in_array($categories['Nom'],$categorieList)) { echo("selected"); } ?> value="<?=$categories['Id']?>"><?=$categories['Nom']?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="row my-3">
                        <div class="col text-center">
                            <input type="submit" value="Valider" class="btn btn-primary" name="valider">
                            <a class="btn btn-danger mx-2" href="./mes-ventes.php" role="button">Annuler</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/css/multi-select-tag.css">
    <script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/js/multi-select-tag.js"></script>
    <script>
        new MultiSelectTag('categories')  // id
    </script>
<?php
    include_once("./includes/footer.inc.php");
?>