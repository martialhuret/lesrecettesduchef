<?php
include_once("libs/modele.php");
include_once("libs/maLibForms.php");
include_once("libs/maLibSecurisation.php");
include_once("libs/maLibUtils.php");

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
    <link rel="stylesheet" type="text/css" href="css/frigo.css" />
    <script src="js/frigo.js"></script>
</head>
<!--  F I N  H E A D  -->

<!--  B O D Y ** -->

<body>

    <input id="searchbar" onkeyup="search_aliment()" type="text" name="search" placeholder="Search aliments..">
    <button onclick="validate_aliment()" class="add-button">&#43;</button>
    <ul id='list'>
        <?php
        $list_aliments = ingredients();
        foreach ($list_aliments as $aliment) {
            echo "<li class='aliments'>" . $aliment['nom'] . "</li>";
        }
        ?>
    </ul>

    <hr>

    <h3>Aliments ajoutés :</h3>
    <div id="added-aliments">
        <?php

        if (isset($_REQUEST["added_aliments"])) {
            $addedAliments = $_REQUEST["added_aliments"];
            foreach ($addedAliments as $aliment) {
                echo "<p class='added-aliments'>" . $aliment . "</p>";
            }
        }
        ?>
    </div>




    <?php
    echo "<form action='controleur.php' method='GET'>";
    if (isset($_REQUEST["added_aliments"])) {
        $addedAliments = $_REQUEST["added_aliments"];
        foreach ($addedAliments as $aliment) {
            echo "<input type='hidden' name='added_aliments[]' value='" . $aliment . "'/>";
            echo "kk";
        }
    }
    ?>
    <input type="submit" name="action" value="Valider !" class="btn" />
    <input type="submit" name="action" value="Passer" class="btn" />
    </form>

</body>

</html>