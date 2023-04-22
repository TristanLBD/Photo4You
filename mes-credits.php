<?php
    include_once("./includes/connection.inc.php");
    if(!isset($_SESSION['PrenomUtilisateur'])) { header('Location: index.php'); }
    if(isset($_POST['valider'])) {
        $credits = htmlspecialchars($_POST['credits']);
        if(is_numeric($credits) && $credits >= 0) {
            $user = $managerUser->getUser($_SESSION['id']);
            if(!$user->setCredit($credits)) { header('Location: mes-credits.php?error=value'); }
            $managerUser->updateCredits($user);
            $_SESSION["credits"] = round($credits);
            header('Location: mes-credits.php?error=success');
        } else {
            header('Location: mes-credits.php?error=value');
        }
    }
    include_once("./includes/header.inc.php");
    echo generationEntete("Photo4You", "Mes crédits.");
?>
    <div class="container">
        <?php
            if(isset($_GET['error'])) {
                $err = htmlspecialchars($_GET['error']);
                switch($err) {
                case 'success':
                    ?>
                        <div class="alert alert-success text-center">
                            <strong><i class="fa-regular fa-circle-check"></i> Succès :</strong> Ajout des crédits éffectué avec succès !
                        </div>
                    <?php
                    break;

                case 'NotEnoughSold':
                    ?>
                        <div class="alert alert-warning text-center">
                            <strong><i class="fas fa-exclamation-triangle"></i> Attention :</strong> Fonds insuffisants pour acheter cette photo, veuillez en ajouter.
                        </div>
                    <?php
                    break;
                
                case 'value':
                    ?>
                        <div class="alert alert-danger text-center">
                            <strong><i class="fas fa-times-circle"></i> Erreur :</strong> Veuillez rentrer <strong>un nombre</strong>.
                        </div>
                    <?php
                    break;

                default:
                    break;
                }
            }
        ?>
        <form class="row needs-validation" action="mes-credits.php" method="POST" novalidate>
                <!-- <div class="row mb-3 justify-content-center">
                    <div class="col-lg-4 col-sm-12">
                        <label for="credits" class="form-label text-decoration-underline">Nombre de crédits :</label>
                        <input type="number" pattern="[0-9]{6}" class="form-control" value="<?=$_SESSION['credits']?>" id="credits" name="credits" required autofocus>
                    </div>
                </div> -->

            <div class="row mb-3 justify-content-center">
                <div class="col-lg-4 col-sm-12">
                    <label for="credits" class="form-label text-decoration-underline text-changing fw-bolder">Nombre de crédits :</label>
                    <div class="input-group">
                        <input  onkeyup="changeMoneyInput(this.value*5,'sum')" type="number" min="0" max="999" pattern="[0-9]{6}" id="credits" name="credits" class="form-control fw-bolder" value="<?=$_SESSION['credits']?>">
                        <span class="input-group-text fw-bolder"><span id="sum"><?= number_format($_SESSION['credits']*5, 0, '.', ' ')?></span> €</span>
                    </div>
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