<?php
    include_once("./includes/connection.inc.php");
    if($_SESSION['type'] != "photographe") { header('Location: index.php'); }
    
    $listePhotos = $managerPhoto->getMesVentes(htmlspecialchars($_SESSION['id']));

    if(isset($_GET["delete"]) && !empty($_GET['delete'])) {
        $managerAppartenir->delete(htmlspecialchars($_GET['delete']));
        // $managerPhoto->delete(htmlspecialchars($_GET['delete']));
        $photo = $managerPhoto->getPhoto($_GET['delete']);
        // var_dump($photo->getUrl());
        $managerPhoto->delete($photo);
        header('Location: mes-ventes.php?error=deleted');
    }

    include_once("./includes/header.inc.php");
    echo generationEntete("Photo4You", "Mes ventes.");
?>        

    <div class="album py-5">
        <div class="container">
        <?php
            if(isset($_GET['error'])) {
                $err = htmlspecialchars($_GET['error']);
                switch($err) {
                    case 'deleted':
                        ?>
                            <div class="alert alert-warning text-center">
                                <strong><i class="fas fa-times-circle"></i> Photo supprimée.</strong>
                            </div>
                        <?php
                        break;

                    case 'modified':
                        ?>
                            <div class="alert alert-warning text-center">
                                <strong><i class="fas fa-times-circle"></i> Photo modifiée.</strong>
                            </div>
                        <?php
                        break;

                    default:
                        break;
                }
            }
        ?>
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
                            <!-- <p class="card-text"> <?=$photo["Categories"]?></p> -->
                            <?php 
                                foreach ($categorieList as  $value) {
                            ?>
                            <span class="badge rounded-pill text-bg-primary"><?=$value?></span>
                            <?php 
                                }
                            ?>
                            <p class="card-text mb-0 mt-3">Publiée le : <?php if(!$photo['checked']) { echo("<span class='text-danger fw-bolder'>En attente de validation.</span>"); } else {echo($photo["DatePublication"]);}?></p>
                            <div class="d-flex justify-content-between align-items-center">
                                <?php if(!$photo['checked']): ?>
                                <a href="./modifier-ventes.php?id=<?=$photo["Id"]?>" type="button" class="btn btn-sm btn-warning">Modifier</a>
                                <?php endif;?>
                                <a href="voir-photo?id=<?=$photo["Id"]?>" target="_blank" type="button" class="btn btn-sm btn-danger">Supprimer</a>
                            </div>
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