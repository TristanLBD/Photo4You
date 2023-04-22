<?php
    include_once("./includes/connection.inc.php");
    include_once("./includes/header.inc.php");
    echo generationEntete("Photo4You", "Des pros au service des particuliers.");
    $photos = $managerPhoto->getLastPhotos(1,5);
    $nbrPhotos = count($photos);

    $sell = $managerPhoto->countNotBoughPhotos();
    $sold = $managerPhoto->countBoughPhotos();
    // $lostPhotos = $managerPhoto->photosWithoutCategorie();
    // vd($lostPhotos);
    ?>
    <div class="container">
        <p class='text-changing fw-bolder fs-1 text-decoration-underline text-center'><?=$sold;?> photo<?php if($sold > 1) { echo('s '); } ?>  vendue<?php if($sold > 1) { echo('s '); } ?> <?=$sell;?> photo<?php if($sell > 1) { echo('s '); } ?> en vente !</p>
        <div class="row justify-content-center">
            <div class="col-lg-10 col-sm-12">

                <h1 class="text-decoration-underline text-center text-changing">Dernières publications :</h1>
                <div id="carouselExampleCaptions" class="carousel slide rounded" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <?php
                            $count = 0;
                            foreach($photos as $row) {
                                $count = $count + 1;
                                if($nbrPhotos > $count) {

                        ?>
                            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="<?=$count?>" aria-label="Slide <?=$count+1?>"></button>
                        <?php
                                }
                            }
                        ?>
                    </div>
                    <div class="carousel-inner">
                        <?php 
                            $count = 0;
                            foreach($photos as $row) {
                            $count = $count + 1;
                        ?>
                        <div style="background-color: black;" class="carousel-item <?php if($count == 1){ echo("active"); } ?>">
                            <!-- sinon width de 100% -->
                            <center><img src="./images/ventes/<?= $row['Url']?>" style="height: 500px; width: auto;"></center> 
                            <div class="carousel-caption d-none d-md-block">
                                <h5 class="text-decoration-underline"><?= $row['Nom'] ?></h5>
                                <p><?= $row['description'] ?></p>
                            </div>
                        </div>
                        <?php
                            }
                            
                            if(!$nbrPhotos) {
                        ?>
                        <div style="background-color: black;" class="carousel-item active">
                            <center><img src="./images/image-placeholder.png" style="height: 500px; width: auto;"></center> 
                            <div class="carousel-caption d-none d-md-block">
                                <h5>Aucunne photo actuelle disponible !</h5>
                                <p>Aucunne photo actuelle disponible !</p>
                            </div>
                        </div>
                        <?php
                            }
                        ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
<?php
    include_once("./includes/footer.inc.php");
?>