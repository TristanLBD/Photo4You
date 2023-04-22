<?php
    include_once("./includes/connection.inc.php");
    $page_courante = 1;
    $iteration = 0;

    // Requête pour compter le nombre total de photos
    $nb_photos = $managerPhoto->countNotBoughPhotos();

    // Nombre de photos par page
    $photos_par_page = 9;

    // Calcul du nombre total de pages
    $nb_pages = ceil($nb_photos / $photos_par_page);

    // Récupération de la page courante
    if(isset($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $nb_pages) {
        $page_courante = $_GET['page'];
    }

    $req = "SELECT utilisateurs.nom as vendeur, photos.vendeur as idVendeur,photos.description,photos.Id,Url,photos.Nom, photos.Prix, GROUP_CONCAT(categories.Nom SEPARATOR ', ') AS Categories
            FROM photos
            JOIN appartenir ON photos.Id = appartenir.Photo
            JOIN categories ON categories.Id = appartenir.Categorie
            JOIN utilisateurs ON utilisateurs.Id = photos.vendeur
            WHERE photos.Proprietaire = photos.Vendeur
            AND checked = 1";

    if(!isset($_POST['valider'])) { header('Location: acheter.php'); die(); }
        $requestArrayValues = [];
            
        if(isset($_POST['min']) && is_numeric($_POST['min']) && strlen((string)$_POST['min'] >= 0)) {
            $req .= " AND photos.prix >= :min";
            $requestArrayValues[':min'] = htmlspecialchars($_POST['min']);
        }
        if(isset($_POST['max']) && is_numeric($_POST['max']) && strlen((string)$_POST['max'] > 0)) {
            $req .= " AND photos.prix <= :max";
            $requestArrayValues[':max'] = htmlspecialchars($_POST['max']);
        }
        if(isset($_POST['nomRecherche']) && strlen((string)$_POST['nomRecherche'] > 0)) {
            $req .= ' AND (photos.nom LIKE :name OR photos.description LIKE :desc)';
            $requestArrayValues[':name'] = "%".htmlspecialchars($_POST['nomRecherche'])."%";
            $requestArrayValues[':desc'] = "%".htmlspecialchars($_POST['nomRecherche'])."%";
        }

        $requestArrayValues[':id_deb'] = ($page_courante - 1) * 9;
        $requestArrayValues[':photos'] = 9;
        $req .= ' GROUP BY photos.Id LIMIT :id_deb, :photos;';

        $listePhotos = $managerPhoto->customRequest($req,$requestArrayValues);
    
    include_once("./includes/header.inc.php");
    echo generationEntete("Photo4You", "Acheter des photos.");
?>
    <div class="album py-5">
        <div class="container">
            <div class="row ">
                <?php foreach ($listePhotos as $photo) { $iteration.=1; $categorieList = explode(", ",$photo['Categories']); ?>
                <div class="col-md-4 fw-bolder grow">
                    <div class="card mb-4 box-shadow">
                        <img class="card-img-top" title="<?=$photo["vendeur"]?>" src="images/ventes/<?php echo $photo["Url"]?>" alt="Card image cap">
                        <div class="card-body">
                            <p class="card-text mb-0"> <?=$photo["vendeur"]?></p>
                            <div class="d-flex justify-content-between align-items-center">
                                <p class="card-text mb-0"> <?=$photo["Nom"]?></p>
                                <p class="card-text mb-0"> <?=$photo["Prix"]?> <i class="fas fa-coins"></i></p>
                            </div>
                            <?php
                                foreach ($categorieList as $value) {
                            ?>
                            <span class="badge rounded-pill text-bg-primary"><?=$value?></span>
                            <?php 
                                }
                            ?>
                            <div class="d-flex justify-content-center align-items-center mt-3">
                                <a href="./voir-photo.php?id=<?=$photo["Id"]?>" target='_blank' type="button" class="btn btn-sm btn-primary px-5">Voir</a>
                            </div>
                        </div>
                    </div>
                </div> 
                <?php }; if(!$iteration) { ?>
                    <div class="col text-center fs-1 fw-bolder">
                        <p class="text-decoration-underline text-changing">Aucune photo ne remplis les critères selectionnés !</p>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center ">
            <li class="page-item"><a class="page-link" href="?page=1">Min</a></li>
            <?php
                // Nombre de pages à afficher avant et après la page courante
                $nb_pages_avant = 4;
                $nb_pages_apres = 4;

                if ($page_courante > 1) {
                    echo '<li class="page-item"><a class="page-link" href="?page='.($page_courante - 1).'"><i class="fa-solid fa-circle-chevron-left"></i></a></li>';
                }

                // Afficher les liens vers les pages avant la page courante
                for ($i = $nb_pages_avant; $i >= 1; $i--) {
                    $page = $page_courante - $i;
                    if ($page > 0) {
                        echo '<li class="page-item"><a class="page-link" href="?page='.$page.'">'.$page.'</a></li>';
                    }
                }

                // Afficher le lien vers la page courante
                echo '<li class="page-item active"><a class="page-link" href="#">'.$page_courante.'</a></li>';

                // Afficher les liens vers les pages après la page courante
                for ($i = 1; $i <= $nb_pages_apres; $i++) {
                    $page = $page_courante + $i;    
                    if ($page <= $nb_pages) {
                        echo '<li class="page-item"><a class="page-link" href="?page='.$page.'">'.$page.'</a></li>';
                    }
                }
                
                // Afficher les liens vers les pages suivantes
                if ($page_courante < $nb_pages) {
                    echo '<li class="page-item"><a class="page-link" href="?page='.($page_courante + 1).'"><i class="fa-solid fa-circle-chevron-right"></i></a></li>';
                }
            ?>
            <li class="page-item"><a class="page-link" href="?page=<?=$nb_pages?>">Max</a></li>
        </ul>
    </nav>
<?php
    include_once("./includes/footer.inc.php");
?>