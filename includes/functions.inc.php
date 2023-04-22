<?php
    function generationEntete(string $titre,string $sous_titre): string {
        $titre = htmlspecialchars($titre);
        $sous_titre = htmlspecialchars($sous_titre);
        return '<div class="text-center mt-5">
                    <img class="d-block mx-auto mb-2" src="images/logo.png" alt="logo Photo4You" width="170" height="115">
                    <h1 class="display-5 text-decoration-underline text-changing">'.$titre.'</h1>
                    <p class="lead text-changing">'.$sous_titre.'</p>
                </div>';
    }

    function genererNomImage(): string {
        $string = "";
        $chars = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z',0,1,2,3,4,5,6,7,8,9];
        for ($i=0; $i < 250; $i++) {
            $string .= $chars[array_rand($chars,1)];
        }
        return $string;
    }

    function passwordCheck($pass) :bool {
        $nb_points = 10;
        $nb_caractere = strlen($pass);
        $points_nbcarac = 0;
        $points_complexite = 0;
        //! Vérification de la longueur du mot de passe
        if($nb_caractere >= 12) { $points_nbcarac = 1; };        
        //! Vérification des lettres minuscules
        if(preg_match("/[a-z]/", $pass)) {  $points_complexite = $points_complexite + 1; }
        //! Vérification des lettres majuscules
        if(preg_match("/[A-Z]/", $pass)) {  $points_complexite = $points_complexite + 2; } 
        //! Vérification des chiffres
        if(preg_match("/[0-9]/", $pass)) {  $points_complexite = $points_complexite + 3; }
        //! Vérification des caractères spéciaux
        if(preg_match("/\W/", $pass)) {  $points_complexite = $points_complexite + 4; }

        $resultat = $points_nbcarac * $points_complexite;
        return($nb_points == $resultat);
    }

    function validateDate($date, $format = 'Y-m-d') {
        $d = DateTime::createFromFormat($format, $date);
        // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
        return $d && $d->format($format) === $date;
    }

    function vd($array) {
        echo "<pre>";
        var_dump($array);
        echo "</pre>";
    }
?>




