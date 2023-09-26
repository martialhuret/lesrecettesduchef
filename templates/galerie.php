<?php
include_once("libs/modele.php");
include_once("libs/maLibForms.php");
include_once("libs/maLibSecurisation.php");
include_once("libs/maLibUtils.php");

// Si la page est appelée directement par son adresse, on redirige en passant par la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php") {
    header("Location:../index.php");
    die("");
}

// Pose quelques soucis avec certains serveurs...
echo "<?xml version=\"1.0\" encoding=\"utf-8\" ?>";
include_once("libs/maLibForms.php");

$nb_recettes = nombreDeRecette();
$recettes_par_page = 9; // Nombre de recettes à afficher par page

// Récupère le numéro de page demandée dans l'URL
$page = valider("page");

// Si le numéro de page n'est pas spécifié ou invalide, on affiche la première page
if (!isset($page) || !is_numeric($page) || $page <= 0) {
    $page = 1;
}

// Calcule l'index de début pour la requête SQL
$index_debut = ($page - 1) * $recettes_par_page;

// Récupère les valeurs des filtres
$duree_min = valider("duree_min");
$note_min = valider("note_min");

// Vérifie si les variables sont vides et les remplace par zéro si c'est le cas
if (empty($duree_min)) {
    $duree_min = 0;
}

if (empty($note_min)) {
    $note_min = 0;
}

// Construit l'URL de filtrage
$filtre_url = "index.php?view=galerie&duree_min=" . urlencode($duree_min) . "&note_min=" . urlencode($note_min);
?>

<!DOCTYPE html>
<html lang="fr">

<!-- **** H E A D **** -->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Les recettes du chef</title>
    <link rel="stylesheet" type="text/css" href="css/accueil.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<!-- **** F I N **** H E A D **** -->

<!-- **** B O D Y **** -->

<body>
    <h1>Galerie</h1>

    <form action='controleur.php' method='GET'>
        <div id="filtre">
            <label for="duree_min">Durée minimale :</label>
            <input type="time" name="duree_min" id="duree_min" value="<?php echo $duree_min; ?>">

            <label for="note_min">Note minimale :</label>
            <input type="number" name="note_min" id="note_min" value="<?php echo $note_min; ?>">

            <button type="submit" id="filtrer-btn">Filtrer</button>
        </div>
    </form>

    <?php
    $recettes = getRecettesFiltrees($index_debut, $recettes_par_page, $duree_min, $note_min);
    $recettes_par_ligne = 3;
    $num_recette = 0;

    while ($num_recette < count($recettes)) {
        echo "<br><br><br><div class='ligne'>";

        for ($j = 0; $j < $recettes_par_ligne; $j++) {
            if ($num_recette >= count($recettes)) {
                break;
            }

            $recette = $recettes[$num_recette];
            $id_recette = $recette['id_page_recette'];
            $titre = $recette['nom'];
            $image = image_recette($id_recette, 1);

            echo "<div class='image-container'>";
            echo "<div class='image'><img src='$image'></div>";
            echo "<div class='titre'>";
            mkLien($url = "index.php", $titre, $qs = "view=page_recette&id_page_recette=$id_recette", $attrs = "");
            echo "</div>";
            echo "</div>";

            $num_recette++;
        }

        echo "</div>";
    }
    ?>

    <div id="plats">
        <?php
        if ($page != 1 && $nb_recettes > $recettes_par_page) {
            echo "<button onclick=\"location.href='$filtre_url'\">Première page</button>";
            $previous_page = $page - 1;
            echo "<button onclick=\"location.href='$filtre_url&page=$previous_page'\">Page précédente</button>";
        }

        if (($page * $recettes_par_page) < $nb_recettes) {
            $next_page = $page + 1;
            echo "<button onclick=\"location.href='$filtre_url&page=$next_page'\">Page suivante</button>";
        }

        if ($page != ceil($nb_recettes / $recettes_par_page) && $nb_recettes > $recettes_par_page) {
            echo "<button onclick=\"location.href='$filtre_url&page=" . ceil($nb_recettes / $recettes_par_page) . "'\">Dernière page</button>";
        }
        ?>
    </div>

    <script>
        // Attache un gestionnaire d'événements pour le clic sur le bouton "Filtrer"
        document.getElementById('filtrer-btn').addEventListener('click', function (e) {
            e.preventDefault(); // Empêche le comportement par défaut du bouton de soumission

            // Récupère les valeurs des filtres
            var duree_min = document.getElementById('duree_min').value;
            var note_min = document.getElementById('note_min').value;

            // Vérifie si les variables sont vides et les remplace par zéro si c'est le cas
            if (duree_min === '') {
                duree_min = 0;
            }

            if (note_min === '') {
                note_min = 0;
            }

            // Construit l'URL de filtrage avec les valeurs des filtres
            var newUrl = "index.php?view=galerie&duree_min=" + encodeURIComponent(duree_min) + "&note_min=" + encodeURIComponent(note_min);

            // Met à jour l'URL de la page
            window.location.href = newUrl;
        });
    </script>
</body>

<!-- **** F I N **** B O D Y **** -->

</html>