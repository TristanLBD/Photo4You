<?php
    include_once("./includes/connection.inc.php");
    if(isset($_SESSION['PrenomUtilisateur'])) { header('Location: index.php'); }
    
    if (isset($_POST['valider'])) {
        if ($utilisateur=$managerUser->getUserByMail($_POST['email'])) {
            if (password_verify($_POST['password'], $utilisateur->getMdp())) {
                if($utilisateur->getBanned() == "1") { header('Location: connexion.php?error=banned');die(); }
                
                session_start ();
                $_SESSION['login'] = true;
                $_SESSION['id'] = $utilisateur->getId();
                $_SESSION['NomUtilisateur'] = $utilisateur->getNom();
                $_SESSION['PrenomUtilisateur'] = $utilisateur->getPrenom();
                $_SESSION['type'] = $utilisateur->getType();
                $_SESSION['Mail'] = $utilisateur->getMail();
                $_SESSION['credits'] = $utilisateur->getCredit();
                header('Location: index.php');
            } else { header('Location: connexion.php?error=account'); }
        } else { header('Location: connexion.php?error=account'); }
    }
    include_once("./includes/header.inc.php");
    echo generationEntete("Photo4You", "Connexion");
?>
    <div class="container">
        <?php
            if(isset($_GET['error'])) {
                $err = htmlspecialchars($_GET['error']);
                switch($err) {
                case 'account':
                    ?>
                        <div class="alert alert-danger text-center">
                            <strong><i class="fas fa-times-circle"></i> Mot de passe ou adresse electronique incorrecte.</strong>
                        </div>
                    <?php
                    break;
                
                case 'banned':
                    ?>
                        <div class="alert alert-danger text-center">
                            <strong><i class="fas fa-times-circle"></i> Vous avez été banni de ce site.</strong>
                        </div>
                    <?php
                    break;

                default:
                    break;
                }
            }
        ?>
        <form class="row needs-validation" action="connexion.php" method="POST" novalidate>
            <div class="row mb-3">
                <div class="col-lg-6 col-sm-12">
                    <label for="nom" class="form-label text-decoration-underline text-changing">Email address :</label>
                    <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" required>
                    <div class="valid-feedback">Email valide. <i class="fa-regular fa-circle-check"></i></div>
                    <div class="invalid-feedback">Emailinvalide. <i class="fa-solid fa-circle-xmark"></i></div>
                </div>
                
                <div class="col-lg-6 col-sm-12">
                    <label for="password" class="form-label text-decoration-underline text-changing">Votre mot de passe :</label>
                    <input type="password" class="form-control" id="password"  name="password"  required>
                    <div class="valid-feedback">Mot de passe valide. <i class="fa-regular fa-circle-check"></i></div>
                    <div class="invalid-feedback">Mot de passe invalide. <i class="fa-solid fa-circle-xmark"></i></div>
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