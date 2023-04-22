<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <a class="navbar-brand" href="./index.php"><img src="images/logo.png" alt="Notre Logo" style="width: 1.5em;"> Photo4You</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav" style="display: flex; justify-content: space-between; width: 100%;">
                <div class="navbarPerso d-flex flex-lg-row  flex-column text-center">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Photos
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="./acheter.php?page=1"><i class="fas fa-images"></i> Acheter</a>
                            <a class="dropdown-item" href="#"><i class="fas fa-star"></i> Les plus populaires</a>
                            <a class="dropdown-item" href="./nouveautes.php?page=1"><i class="fas fa-camera"></i> Les nouveautés</a>
                        </div>
                    </li>
                    <?php
                    if (isset($_SESSION["type"])): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Mon Compte (<?=ucfirst($_SESSION["type"])?>)
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="./mes-credits.php"><i class="fas fa-coins"></i> Mes Crédits (<?=$_SESSION['credits']?>)</a>
                                <?php 
                                    if($_SESSION["type"] == "client") { 
                                        echo('<a class="dropdown-item" href="mes-achats.php"><i class="fas fa-shopping-cart"></i> Mes Achats</a>'); 
                                    } else if ($_SESSION["type"] == "photographe") {
                                        echo('<a class="dropdown-item" href="mes-ventes.php"><i class="fad fa-film-canister"></i> Mes articles</a>'); 
                                        echo('<a class="dropdown-item" href="ajouter-vente.php"><i class="fas fa-plus-circle"></i> AJouter un article</a>'); 
                                    }
                                ?>
                            </div>
                        </li>
                    <?php
                    endif;
                    ?>

                    <?php
                    if (isset($_SESSION["type"]) && $_SESSION["type"] == "admin"): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Admin
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="./categories.php"><i class="fa-solid fa-bookmark"></i> Catégories</a>
                                <a class="dropdown-item" href="./utilisateurs.php"><i class="fa-solid fa-users"></i> Utilisateurs</a>
                                <a class="dropdown-item" href="./utilisateurs-bannis.php"><i class="fa-solid fa-ban"></i> Utilisateurs Bannis</a>
                                <a class="dropdown-item" href="./validations.php"><i class="fa-regular fa-circle-check"></i> Validations</a>
                            </div>
                        </li>
                    <?php
                    endif;
                    ?>
                    <div class="dropdown" onclick="updateRangeNavbar()">
                    <button type="button"  class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                        Rechercher
                    </button>
                    <form method="POST" action="./recherche.php?page=1" class="dropdown-menu p-4 needs-validation" style="min-width: 250px;" novalidate>
                        <div class="mb-3">
                            <label for="nomRecherche" class="form-label text-decoration-underline">Nom</label>
                            <input type="text" class="form-control" id="nomRecherche" name="nomRecherche">
                        </div>
                        <div class="mb-4">
                            <div class="price-input">
                                <div class="field">
                                    <label for="min" class="text-decoration-underline">Min</label>
                                    <input id="min" type="number" class="input-min" value="0">
                                </div>
                                <div class="separator">-</div>
                                <div class="field">
                                    <label for="max" class="text-decoration-underline">Max</label>
                                    <input id="max" type="number" class="input-max" value="<?=$maxPriceForRange?>">
                                </div>
                            </div>
                            <div class="slider">
                                <div class="progress"></div>
                            </div>
                            <div class="range-input">
                                <input type="range" id="updateRange" class="range-min" name="min" min="0" max="<?=$maxPriceForRange?>" value="0" step="1">
                                <input type="range" class="range-max" min="0" name="max" max="<?=$maxPriceForRange?>" value="<?=$maxPriceForRange?>" step="1">
                            </div>
                        </div>
                        <button name="valider" type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Rechercher</button>
                    </form>
                </div>
                </div>







                <div class="navbarPerso d-flex flex-lg-row  flex-column text-center">
                    <a class="btn  mx-2" role="button" id="colorChanger"><i class="fas fa-moon"></i></a>
                    <?php if (isset($_SESSION["login"])): ?>
                        <a class="btn btn-danger" href="./logout.php" role="button"><i class="fa-solid fa-power-off"></i> Déconnexion</a>
                    <?php else: ?>
                        <a class="btn btn-success mx-2" href="./inscription.php" role="button"><i class="fa-solid fa-user-plus"></i> Inscription</a>
                        <a class="btn btn-primary mx-2" href="./connexion.php" role="button"><i class="fa-solid fa-right-to-bracket"></i>  Connexion</a>
                    <?php endif; ?>
                </div>
            </ul>
        </div>
    </div>
</nav>