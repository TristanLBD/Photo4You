<?php
    include_once("./includes/connection.inc.php");
    if(!isset($_SESSION['type']) || $_SESSION['type'] != "client") { header('Location: index.php'); }
    
    $listePhotos = $managerPhoto->getMesAchats($_SESSION['id']);

    include_once("./includes/header.inc.php");
    echo generationEntete("Photo4You", "Mes achats.");
?>
    <div class="album py-5">
        <div class="container">
            <div class="row">
                <?php foreach ($listePhotos as $photo) { $categorieList = explode(", ",$photo['Categories']); ?>
                <div class="col-md-4 fw-bolder grow">
                    <div class="card mb-4 box-shadow">
                        <img class="card-img-top" title="<?=$photo["Nom"]?>" src="images/ventes/<?php echo $photo["Url"]?>" alt="Card image cap">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <p class="card-text mb-0"> <?=$photo["Nom"]?></p>
                                <p class="card-text mb-0"> <?=$photo["Prix"]?> <i class="fas fa-coins"></i></p>
                            </div>
                            <?php 
                                foreach ($categorieList as  $value) {
                            ?>
                            <span class="badge rounded-pill text-bg-primary"><?=$value?></span>
                            <?php 
                                }
                            ?>
                            <p class="card-text mb-0 mt-3">Publiée le : <?=$photo["DatePublication"]?></p>
                            <p class="card-text mb-0 mt-3">Vendu par : <?=$photo["vendeur"]?></p>
                            
                            <a class="btn btn-primary" href="./images/ventes/<?=$photo['Url']?>" download="<?=$photo['Nom']?>" role="button"><i class="fas fa-file-download"></i> Télécharger</a>
                        </div>
                    </div>
                </div> 
                <?php }; ?>
            </div>
        </div>
    </div>
<?php
    include_once("./includes/footer.inc.php");
?>