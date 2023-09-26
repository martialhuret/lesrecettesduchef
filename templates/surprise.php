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
	<link rel="stylesheet" type="text/css" href="css/surprise.css" />
</head>
<!-- **** F I N **** H E A D **** -->


<!-- **** B O D Y **** -->

<body>
	<h1> SURPRISE ! </h1>

	<div id="corps">
		<?php
		$alea = rand(1, 20);
		$clique = titre_recette($alea);
		echo "<div id='texte'>";
		echo "Nous vous proposons une magnifique recette de " . $clique . " !</div>";
		$res = image_recette($alea, 0);
		echo "<div id='cadre'><div id='image'> <img src=" . $res . "></div>";
		echo "</div> </br> </br>";
		mkLien($url = "index.php", "Voir la recette", $qs = "view=page_recette&id_page_recette=$alea", $attrs = "");



		?>
	</div>
</body>
<!-- **** F I N **** B O D Y **** -->

</html>