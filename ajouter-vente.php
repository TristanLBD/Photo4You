<?php
    $title = "Photo4You | Vente";
    include_once("./includes/connection.inc.php");
    if($_SESSION['type'] != "photographe") { header('Location: index.php'); }

    if(isset($_POST['valider'])) {
        $nom = htmlspecialchars($_POST['nom']);
        $credits = htmlspecialchars($_POST['credits']);
        $description = htmlspecialchars($_POST['description']);
        $categories = $_POST['categories'];

        //! gerer la photo
        if(file_exists($_FILES['image']['tmp_name']) || is_uploaded_file($_FILES['image']['tmp_name'])) {
            $urlPhoto = $_FILES['image'];
            $nom_photo = $urlPhoto['name'];
            $ext = pathinfo($nom_photo, PATHINFO_EXTENSION);

            $allowedExtensions = array('gif', 'png', 'jpg', 'webp');
            if (!in_array($ext, $allowedExtensions)) {
                echo 'error';
                die();
            }

            try {
                $date = date('Y-m-d');
                $nom_image = genererNomImage().".".$ext;

                while($managerPhoto->urlExist($nom_image)) {
                    $nom_image = genererNomImage().".".$ext;
                }
                
                $photo = new Photo(['Nom' => $nom, 'Description' => $description, 'Prix' => $credits, 'Vendeur' => $_SESSION['id'], 'Proprietaire' => $_SESSION['id'], 'Url' => $nom_image, 'DatePublication' => $date]);
                $managerPhoto->add($photo);

                foreach ($categories as $row) {
                    $appartenir = new Appartenir(['Photo' => $photo->getId(), 'Categorie' => $row]);
                    $managerAppartenir->add($appartenir);
                }

                move_uploaded_file($urlPhoto['tmp_name'],'images/ventes/'.$nom_image);
                header('Location: ajouter-vente.php?error=add&nom='.$nom);
            } catch(PDOException $e) {
                echo $e->getMessage();
                header('Location: ajouter-vente.php'); die();
            }
        }
    }

    include_once("./includes/header.inc.php");
    echo generationEntete("Photo4You", "Mettre une photo en vente.");
?>
    <div class="container">
        <?php
            if(isset($_GET['error']) && isset($_GET['nom'])) {
                $err = htmlspecialchars($_GET['error']);
                switch($err) {
                case 'add':
                    ?>
                        <div class="alert alert-success text-center">
                            <strong><i class="fa-regular fa-circle-check"></i> Succès :</strong> L'image <strong><?=htmlspecialchars($_GET['nom'])?></strong> viens d'etre ajoutée.
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

        <div class="row">
            <div class="col-lg-6">
                <p class="text-center fs-3 text-decoration-underline text-changing">Votre Image :</p>
                <img onclick="triggerClick('#image')" src="./images/image-placeholder.png" id="photo" class="img-fluid d-flex mx-auto my-3 rounded" style="max-height: 500px; border: 2px solid white;">
            </div>

            <div class="col-lg-6">
                <p class="text-center fs-3 text-decoration-underline text-changing">Informations complémentaires :</p>
                <form class="row needs-validation" action="ajouter-vente.php" method="POST" novalidate enctype="multipart/form-data">

                    <div class="col-12">
                        <label for="nom" class="form-label text-changing fw-bolder text-decoration-underline">Nom :</label>
                        <input type="text" name="nom" id="nom" class="form-control" required autofocus>
                        <div class="valid-feedback">Nom valide. <i class="fa-regular fa-circle-check"></i></div>
                        <div class="invalid-feedback">Nom invalide <i class="fa-solid fa-circle-xmark"></i></div>
                    </div>

                    <div class="col-12 mt-3">
                        <label for="description" class="form-label text-changing fw-bolder text-decoration-underline">Description :</label>
                        <textarea required class="form-control" id="description" name="description"></textarea>
                        <div class="valid-feedback">Description valide. <i class="fa-regular fa-circle-check"></i></div>
                        <div class="invalid-feedback">Description invalide <i class="fa-solid fa-circle-xmark"></i></div>
                    </div>

                    <div class="col-12 mt-3">
                        <label for="credits" class="form-label text-changing fw-bolder text-decoration-underline">Nombre de crédits :</label>
                        <div class="input-group">
                            <input required onkeyup="changeMoneyInput(this.value*5,'sum')" type="number" min="0" pattern="[0-9]{6}" id="credits" name="credits" class="form-control fw-bolder" value="0">
                            <span class="input-group-text fw-bolder"><span id="sum">0</span>€</span>
                        </div>
                    </div>

                    <div class="col-12 mt-3">
                        <label for="expertise" class="form-label text-changing text-decoration-underline fw-bolder">Photo de l'employé(e)</label><br>
                        <input required type="file" accept="image/*" onchange="actualiserPhoto(this, 'photo')" id="image" name="image">
                        <div class="valid-feedback">Image valide !</div>
                        <div class="invalid-feedback">Image invalide !</div>
                    </div>

                    <div class="col-12 mt-3">
                        <label for="categories" class="form-label text-changing fw-bolder text-decoration-underline">Catégorie(s) :</label><br>
                        <select required name="categories[]" id="categories" multiple>
                            <?php foreach($managerCategorie->getList() as $categorie): ?>
                                <option value="<?=$categorie['Id']?>"><?=$categorie['Nom']?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>


                    <div class="row my-3">
                        <div class="col text-center">
                            <input type="submit" value="Valider" class="btn btn-primary" name="valider">
                            <input type="reset" value="Annuler" onclick="resetFormImage('photo')" class="btn btn-danger">
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