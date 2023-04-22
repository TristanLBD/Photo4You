<?php
    $host = "127.0.0.1";
    $db = "photo4you2";
    $user = "root";
    $pass ="";

    try {
        $db = new PDO("mysql:host =$host;dbname=$db;charset=utf8",$user,$pass);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo'Echec de la connexion :' .$e->getMessage();
        // echo'Echec de la connexion :' .$e->getMessage();
        die();
    }
    include_once("./includes/functions.inc.php");

    if (!isset($_SESSION)) {
        session_start();
    }
    
    //! Pour le chargement automatique des classes
    function chargerClasse($classname) {
        require ('classes/'.$classname.'.class.php');
    }
    spl_autoload_register('chargerClasse');

    $managerUser = new UserManager($db);
    $managerCategorie = new CategorieManager($db);
    $managerPhoto = new PhotoManager($db);
    $managerAppartenir = new AppartenirManager($db);
    $maxPriceForRange = $managerPhoto->getMaxPriceOfAvailablesPhotos();
?>