<?php

include_once("libs/modele.php");

include_once("libs/maLibForms.php");
//C'est la propriété php_self qui nous l'indique : 
// Quand on vient de index : 
// [PHP_SELF] => /chatISIG/index.php 
// Quand on vient directement par le répertoire templates
// [PHP_SELF] => /chatISIG/templates/accueil.php

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
// Pas de soucis de bufferisation, puisque c'est dans le cas où on appelle directement la page sans son contexte
if (basename($_SERVER["PHP_SELF"]) != "index.php") {
    header("Location:../index.php?view=accueil");
    die("");
}

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">


<!-- **** H E A D **** -->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Les recettes du chef</title>
    <link rel="stylesheet" type="text/css" href="css/planning.css" />
</head>
<!-- **** F I N **** H E A D **** -->


<!-- **** B O D Y **** -->

<body id="contenu">

    <div id="titre">
        <h1> Planning </h1>
    </div>
    <br><br>
    <div id="corps" style="border-radius:1000px">
        <?php

        $idPlanning = valider("id_planning");
        if (!$idPlanning) {
            // pas d'identifiant ! On redirige vers la page accueil
        
            header("Location:index.php?view=accueil");
            die("id_planning manquant");
        }

        //enregistrer planning pour mettre dans compte 
        //affichage des recettes de manière aléatoire et sans répétition
        

        $recettes = recup_recettes_planning($idPlanning);
        if (count($recettes) == 14) {
            for ($j = 0; $j < 2; $j++) {
                echo "<div class='l1'>";
                for ($i = 0; $i < 7; $i++) {
                    $index = ($j * 7) + $i;
                    switch ($index) {
                        case 0:
                            echo "<div class='jour'><p>Lundi midi</p></br>";
                            break;
                        case 1:
                            echo "<div class='jour'><p>Mardi midi</p>";
                            break;
                        case 2:
                            echo "<div class='jour'><p>Mercredi midi</p>";
                            break;
                        case 3:
                            echo "<div class='jour'><p>Jeudi midi</p>";
                            break;
                        case 4:
                            echo "<div class='jour'><p>Vendredi midi</p>";
                            break;
                        case 5:
                            echo "<div class='jour'><p>Samedi midi</p>";
                            break;
                        case 6:
                            echo "<div class='jour'><p>Dimanche midi</p>";
                            break;
                        case 7:
                            echo "<div class='jour'><p>Lundi soir</p>";
                            break;
                        case 8:
                            echo "<div class='jour'><p>Mardi soir</p>";
                            break;
                        case 9:
                            echo "<div class='jour'><p>Mercredi soir</p>";
                            break;
                        case 10:
                            echo "<div class='jour'><p>Jeudi soir</p>";
                            break;
                        case 11:
                            echo "<div class='jour'><p>Vendredi soir</p>";
                            break;
                        case 12:
                            echo "<div class='jour'><p>Samedi soir</p>";
                            break;
                        case 13:
                            echo "<div class='jour'><p>Dimanche soir</p>";
                            break;

                    }
                    if ($index < count($recettes)) {
                        $recette = $recettes[$index];
                        $res = image_recette($recette['id_page_recette'], 1);
                        echo "<div class='image-contenu'>";
                        echo "<div class='photo'>";
                        $clique1 = "<img src='" . $res . "'/>";
                        mkLien($url = "index.php", $clique1, $qs = "view=page_recette&id_page_recette=" . $recette['id_page_recette'], $attrs = "");
                        echo "</div>";
                        $clique = titre_recette($recette['id_page_recette']);
                        echo "<div class='nom'>";
                        mkLien($url = "index.php", $clique, $qs = "view=page_recette&id_page_recette=" . $recette['id_page_recette'], $attrs = "");
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                    }
                }
                echo "</div>";
            }

        } else {
            echo "<div class='l1'>Le planning n'est pas complet</div>";
        }

        ?>
    </div>
</body>




<!-- **** F I N **** B O D Y **** -->

</html>