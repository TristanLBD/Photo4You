<?php
    $title = "Photo4You | Achat";
    include_once("./includes/connection.inc.php");
    // if($_SESSION['type'] != "photographe") { header('Location: index.php'); }
    if(!isset($_GET['id'])) { header('Location: acheter.php'); }
    
    $idPhoto = htmlspecialchars($_GET['id']);
    if(!$photo = $managerPhoto->getBuyablePhotoById($idPhoto)) { header('Location: acheter.php'); }

    if(isset($_GET['delete']) && $_GET['delete'] == "true" && isset($_GET['id']) && !empty($_GET['id']) && $photo['idVendeur'] == $_SESSION["id"]) {
        $managerAppartenir->delete(htmlspecialchars($_GET['id']));
        // $managerPhoto->delete(htmlspecialchars($_GET['delete']));
        $photo = $managerPhoto->getPhoto($_GET['id']);
        // var_dump($photo->getUrl());
        $managerPhoto->delete($photo);
        header('Location: mes-ventes.php?error=deleted');
    }

    if(isset($_POST['valider']) && !empty($_POST['valider'])) {
        $vendeur = $managerUser->getUser($photo["vendeur"]);
        $acheteur = $managerUser->getUser($_SESSION['id']);
        $photoTransaction = new Photo($photo);

        if($acheteur->getCredit() < $photoTransaction->getPrix()) { header('Location: mes-credits.php?error=NotEnoughSold'); die();}

        
        $transaction = $managerPhoto->transaction($photoTransaction, $vendeur, $acheteur,$managerUser,$managerPhoto);
        header('Location: mes-achats.php');
    }
    
    include_once("./includes/header.inc.php");
    echo generationEntete("Photo4You", "Acheter une photo.");
?>
<div class="container mb-3">
        <div class="row text-changing">
            <div class="col-lg-7 col-sm-12 mb-5">
                <img src="./images/ventes/<?=$photo['Url']?>" alt="Votre Image" class="img-fluid rounded grow">
            </div>
            <div class="col-lg-5 col-sm-12">
                <div class="row">
                    <div class="col d-flex justify-content-between">
                        <span class="text-decoration-underline fw-bolder">Nom :</span>
                        <span class="text-decoration-underline fw-bolder"><?= $photo['Nom']?></span>
                    </div>
                </div>

                <hr class="mx-5">

                <div class="row">
                    <div class="col">
                        <p class="text-decoration-underline fw-bolder">Description :</p>
                        <p><?= $photo['description']?></span>

                    </div>
                </div>

                <hr class="mx-5">

                <div class="row">
                    <div class="col d-flex justify-content-between">
                        <span class="text-decoration-underline fw-bolder">Vendeur :</span>
                        <span class="text-decoration-underline fw-bolder"><?= $photo['nomVendeur']?></span>
                    </div>
                </div>
                
                <hr class="mx-5">

                <div class="row">
                    <div class="col d-flex justify-content-between">
                        <span class="text-decoration-underline fw-bolder">Publiée le  :</span>
                        <span class="text-decoration-underline fw-bolder"><?= $photo['DatePublication']?></span>
                    </div>
                </div>

                <hr class="mx-5">

                <div class="row">
                    <div class="col d-flex justify-content-between">
                        <span class="text-decoration-underline fw-bolder">Prix :</span>
                        <span><span class="text-decoration-underline fw-bolder"><?=$photo['Prix']?></span> <i class="fas fa-coins"></i></span>
                    </div>
                </div>

                <hr class="mx-5">

                <?php if(isset($_SESSION['type']) && $_SESSION['type'] == "photographe" && $_SESSION['id'] == $photo['idVendeur']) { ?>
                    <div class="row">
                        <div class="col d-flex justify-content-center">
                            <a type="button" class="btn btn-danger" href="./voir-photo.php?delete=true&id=<?=$idPhoto?>">Supprimer</a>
                        </div>
                    </div>
                <?php } elseif(isset($_SESSION['type']) && $_SESSION['type'] == "client") { ?>
                    <form class="row needs-validation" action="voir-photo.php?id=<?=$idPhoto?>" method="POST" novalidate enctype="multipart/form-data">
                        <div class="col d-flex justify-content-center">
                            <input onclick='askForBuying("<?=$photo["Nom"]?>",<?=$photo["Prix"]?>)' type="submit" value="Acheter" class="btn btn-success" name="valider">
                        </div>
                    </form>
                <?php } else { ?>
                    <div class="row mt-3">
                        <div class="col d-flex justify-content-center">
                            <div class="alert alert-danger">
                                Connectez vous en tant que <span class="fw-bolder">client</span> pour éffectuer un achat
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col d-flex justify-content-center">
                            <button type="button" class="btn btn-warning disabled">Acheter</button>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
<?php
    include_once("./includes/footer.inc.php");
?>