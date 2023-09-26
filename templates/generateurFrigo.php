<?php
// Si la page est appelée directement par son adresse, on redirige en passant par la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php") {
    header("Location:../index.php");
    die("");
}

// Pose quelques soucis avec certains serveurs...
echo "<?xml version=\"1.0\" encoding=\"utf-8\" ?>";
include_once("libs/maLibForms.php");
?>


<!DOCTYPE html>
<html lang="fr">

<!-- **** H E A D **** -->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Les recettes du chef</title>
    <link rel="stylesheet" type="text/css" href="css/generateurFrigo.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<!-- **** F I N **** H E A D **** -->



<!-- **** B O D Y **** -->

<body>
    <h1>Voulez vous remplir le frigo pour obtenir un </br> planning de repas personnalisé ? </h1>

    <?php
    mkForm("controleur.php"); ?>
    <input type="submit" name="action" value="Valider" class="btn" />
    <input type="submit" name="action" value="Passer" class="btn" />
    <php endForm(); ?>

</body>

<!-- **** F I N **** B O D Y **** -->

</html>