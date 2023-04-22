<?php
    include_once("./includes/connection.inc.php");
    if($_SESSION['type'] != "admin") { header('Location: index.php'); }
    
    if(isset($_GET["accept"]) && !empty($_GET['accept'])) {
        $managerPhoto->check(htmlspecialchars($_GET['accept']));
        header('Location: validations.php?error=accepted');
    }

    if(isset($_GET["delete"]) && !empty($_GET['delete'])) {
        $photo = $managerPhoto->getPhoto($_GET['delete']);
        $managerAppartenir->delete(htmlspecialchars($_GET['delete']));
        // $managerPhoto->delete(htmlspecialchars($_GET['delete']));
        $managerPhoto->delete($photo);
        header('Location: validations.php?error=deleted');
    }

    if(isset($_GET["ban"]) && !empty($_GET['ban'])) {
        $managerUser->banUser(htmlspecialchars($_GET['ban']));
        header('Location: validations.php?error=banned');
    }

    $listePhotos = $managerPhoto->getNonConfirmedPhotos();


    include_once("./includes/header.inc.php");
    echo generationEntete("Photo4You", "Gestion des dernières publications");
?>        

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

                    case 'banned':
                        ?>
                            <div class="alert alert-warning text-center">
                                <strong><i class="fas fa-times-circle"></i> Utilisateur bannis.</strong>
                            </div>
                        <?php
                        break;

                    case 'accepted':
                        ?>
                            <div class="alert alert-success text-center">
                                <strong><i class="fa-regular fa-circle-check"></i> Succès :</strong> L'image à été acceptée.
                            </div>
                        <?php
                        break;

                    case 'modified':
                        ?>
                            <div class="alert alert-warning text-center">
                                <strong><i class="fa-regular fa-circle-check"></i> Succès :</strong> L'image à été modifiée.
                            </div>
                        <?php
                        break;

                    default:
                        break;
                }
            }
            
        ?>
    <?php foreach($listePhotos as $photo) : $categorieList = explode(", ",$photo['Categories']);?>

    <div class="row my-4 border rounded">
        <div class="col-lg-4">
            <img class="img-fluid" src="./images/ventes/<?=$photo['Url']?>">
        </div>
        <div class="col-lg-8 d-flex flex-column justify-content-between text-changing">
            <div class="row flex-grow-1">
                <div class="col d-flex flex-column justify-content-between">
                    <div class="d-flex justify-content-between align-items-center my-3">
                        <p class="card-text mb-0 fw-bolder"><span class="text-decoration-underline">Nom :</span> <?=$photo["Nom"]?></p>
                        <p class="card-text mb-0 fw-bolder"> <?=$photo["Prix"]?> <i class="fas fa-coins"></i></p>
                    </div>
                    <p class="card-text mb-0 fw-bolder"><span class="text-decoration-underline">Vendeur :</span> <?=$photo["nomVendeur"]?></p>
                    <p class="card-text mb-0 fw-bolder"><span class="text-decoration-underline">Description :</span> <?=$photo["description"]?></p>
                    <div>
                        <?php foreach ($categorieList as $value) { ?>
                            <span class="badge rounded-pill text-bg-primary"><?=$value?></span>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <div class="row my-3 ">
                <div class="col d-flex justify-content-between justify-end">
                    <a class="btn btn-success mx-2 grow text-white" href="?accept=<?=$photo['Id']?>" role="button"><i class="fas fa-check-circle"></i> Accepter</a>
                    <a class="btn btn-danger mx-2 grow text-white" href="?delete=<?=$photo['Id']?>" role="button"><i class="fas fa-times-circle"></i> Supprimer</a>
                    <a class="btn btn-warning mx-2 grow text-white" href="./modifier-ventes.php?id=<?=$photo['Id']?>&admin=admin" role="button"><i class="fas fa-exclamation-triangle"></i> Modifier</a>
                    <a class="btn btn-danger mx-2 grow text-white" href="?ban=<?=$photo['vendeur']?>" role="button"><i class="fas fa-times-circle"></i> Bannir</a>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<?php
    include_once("./includes/footer.inc.php");
?>