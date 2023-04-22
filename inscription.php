<?php
    include_once("./includes/connection.inc.php");
    
    if(isset($_SESSION['PrenomUtilisateur'])) { header('Location: index.php');die(); }
        if (isset($_POST['valider'])) {
            if(!isset($_POST['nom']) || !isset($_POST['prenom']) || !isset($_POST['email']) || !isset($_POST['password']) || !isset($_POST['passwordConfirm']) || !isset($_POST['choixType'])) { header('Location: inscription.php?error=missing'); die();}

            $nom = htmlspecialchars($_POST['nom']);
            $prenom = htmlspecialchars($_POST['prenom']);
            $email = htmlspecialchars($_POST['email']);
            $password = htmlspecialchars($_POST['password']);
            $passwordConfirm = htmlspecialchars($_POST['passwordConfirm']);
            $choixType = htmlspecialchars($_POST['choixType']);
            
            if($password != $passwordConfirm) { header('Location: ./inscription.php?error=passworddiff'); die();}
            if(!passwordCheck($password)) { header('Location: ./inscription.php?error=password'); die();}

            $cost = ['cost' => 12];
            $password = password_hash($password, PASSWORD_BCRYPT, $cost);
            
            $user = new User(['Nom' => $nom, 'Prenom' => $prenom, 'Mail' => $email, 'Mdp' => $password,  'Type' => $choixType]);
            $managerUser->add($user);
            header('Location: connexion.php');
            die();
        }
    include_once("./includes/header.inc.php");
    ?>
    <div class="container">
        <?php echo generationEntete("Photo4You", "Inscription"); ?>
        <?php
            if(isset($_GET['error']) && !empty($_GET["error"])) {
                $err = htmlspecialchars($_GET['error']);
                switch($err) {
                case 'password':
                    ?>
                        <div class="alert alert-danger text-center">
                            <strong><i class="fas fa-times-circle"></i> Le mot de passe n'est pas assez sécurisé !</strong>
                        </div>
                    <?php
                    break;

                case 'passworddiff':
                    ?>
                        <div class="alert alert-danger text-center">
                            <strong><i class="fas fa-times-circle"></i> Les mots de passes renseignés sont différents</strong>
                        </div>
                    <?php
                    break;

                case 'missing':
                    ?>
                        <div class="alert alert-danger text-center">
                            <strong><i class="fas fa-times-circle"></i> Une erreur est survenue</strong>
                        </div>
                    <?php
                    break;

                default:
                    break;
                }
            }
        ?>
        <form class="row needs-validation" action="inscription.php" method="POST" novalidate>
            <div class="row mb-3">
                <div class="col-lg-4 col-sm-12">
                    <label for="prenom" class="form-label text-decoration-underline text-changing">Prénom :</label>
                    <input type="text" class="form-control" id="prenom" name="prenom" required>
                    <div class="valid-feedback">Prénom valide. <i class="fa-regular fa-circle-check"></i></div>
                    <div class="invalid-feedback">Prénom invalide. <i class="fa-solid fa-circle-xmark"></i></div>
                </div>
                
                <div class="col-lg-4 col-sm-12">
                    <label for="nom" class="form-label text-decoration-underline text-changing">Nom :</label>
                    <input type="text" name="nom" id="nom" class="form-control" required>
                    <div class="valid-feedback">Nom valide. <i class="fa-regular fa-circle-check"></i></div>
                    <div class="invalid-feedback">Nom invalide <i class="fa-solid fa-circle-xmark"></i></div>
                </div>

                <div class="col-lg-4 col-sm-12 ">
                    <label for="nom" class="form-label text-decoration-underline text-changing">Vous êtes :</label><br>
                    <div class="btn-group btn-group-toggle">
                        <input type="radio" class="btn-check" name="choixType" id="client" value="client" required autocomplete="off">
                        <label class="btn btn-outline-primary" for="client">Client</label>

                        <input type="radio" class="btn-check" name="choixType" id="photographe" value="photographe" required autocomplete="off">
                        <label class="btn btn-outline-primary" for="photographe">photographe</label>
                        <div class="valid-feedback">Type de compte valide<i class="fa-regular fa-circle-check"></i></div>
                        <div class="invalid-feedback">Veuillez choisir un type de compte.<i class="fa-solid fa-circle-xmark"></i></div>
                    </div>
                </div>
            </div>


            <div class="row mb-3">
                <div class="col-lg-4 col-sm-12">
                    <label for="email" class="form-label text-decoration-underline text-changing">Email address :</label>
                    <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" required>
                    <div class="valid-feedback">Nom valide. <i class="fa-regular fa-circle-check"></i></div>
                    <div class="invalid-feedback">Nom invalide. <i class="fa-solid fa-circle-xmark"></i></div>
                </div>
                
                <div class="col-lg-4 col-sm-12">
                    <label for="password" class="form-label text-decoration-underline text-changing">Votre mot de passe :</label>
                    <input type="password" onkeyup='passwordCheck(this,"password")' class="form-control" id="password" name="password" pattern='^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*\W).{12,}$' required>
                    <div class="valid-feedback">Mot de passe valide. <i class="fa-regular fa-circle-check"></i></div>
                    <div class="invalid-feedback">Mot de passe invalide. <i class="fa-solid fa-circle-xmark"></i></div>
                </div>

                <div class="col-lg-4 col-sm-12">
                    <label for="passwordConfirm" class="form-label text-decoration-underline text-changing">Confirmez votre mot de passe :</label>
                    <input type="password" class="form-control" id="passwordConfirm" name="passwordConfirm" pattern='^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*\W).{12,}$' required>
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