<?php
    include_once("./includes/connection.inc.php");


    include_once("./includes/header.inc.php");
?>  
    <div class="container my-3">
        <div class="row text-center">
            <div class="alert alert-danger m-5" role="alert"><i class="fa-solid fa-circle-xmark"></i> Connexion a la base de donnée impossible.</div>
        </div>
        <div class="d-flex row justify-content-center">
            <?= generationEntete("Photo4You", "Erreur de connexion."); ?>
        </div>
    </div>
<?php
    include_once("./includes/footer.inc.php");
?>  