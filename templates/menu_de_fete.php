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
	<link rel="stylesheet" type="text/css" href="css/menu_de_fete.css" />
</head>
<!-- **** F I N **** H E A D **** -->


<!-- **** B O D Y **** -->

<body>
	<h1 id="pres"> Menu de fête </h1>
	<div id="intitule">
		<p>Vous avez une occasion spéciale à fêter ?
			</br>Nous vous proposons : </p>
	</div>

	<div id="corps">
		<?php
		for ($i = 0; $i < 4; $i++) {
			switch ($i) {
				case 0:

					$alea = rand(1, 21);
					if (verifier_recette_bdd($alea, $i) != NULL) {
						echo "<div class='contenu'><p> En apéritif : </p>";
						$res = image_recette_fete($alea, $i);
						echo "<div class='image'> <img src=" . $res . "></div>";
						$clique = titre_recette_fete($alea, $i);
						//voir si peu mettre la class dans attrs ?????
						echo "<div class='titre'>";
						mkLien($url = "index.php", $clique, $qs = "view=page_recette&id_page_recette=$alea", $attrs = "");
						echo "</div></div>";
						break;
					} else {
						$i--;

						break;
					}
				case 1:
					$alea = rand(1, 21);
					if (verifier_recette_bdd($alea, $i) != NULL) {
						echo "<div class='contenu'><p> En entrée : </p>";
						$res = image_recette_fete($alea, $i);
						echo "<div class='image'> <img src=" . $res . "></div>";
						$clique = titre_recette_fete($alea, $i);
						echo "<div class='titre'>";
						mkLien($url = "index.php", $clique, $qs = "view=page_recette&id_page_recette=$alea", $attrs = "");
						echo "</div></div>";
						break;
					} else {
						$i--;

						break;
					}


				case 2:
					$alea = rand(1, 21);
					if (verifier_recette_bdd($alea, $i) != NULL) {
						echo "<div class='contenu'><p> En plat : </p>";
						$res = image_recette_fete($alea, $i);
						echo "<div class='image'> <img src=" . $res . "></div>";
						$clique = titre_recette_fete($alea, $i);
						echo "<div class='titre'>";
						mkLien($url = "index.php", $clique, $qs = "view=page_recette&id_page_recette=$alea", $attrs = "");
						echo "</div></div>";
						break;
					} else {
						$i--;

						break;
					}

				case 3:
					$alea = rand(1, 21);
					if (verifier_recette_bdd($alea, $i) != NULL) {
						echo "<div class='contenu'><p> En dessert : </p>";
						$res = image_recette_fete($alea, $i);
						echo "<div class='image'> <img src=" . $res . "></div>";
						$clique = titre_recette_fete($alea, $i);
						echo "<div class='titre'>";
						mkLien($url = "index.php", $clique, $qs = "view=page_recette&id_page_recette=$alea", $attrs = "");
						echo "</div></div>";
						break;
					} else {
						$i--;

						break;
					}


			}
		}


		?>
	</div>
</body>
<!-- **** F I N **** B O D Y **** -->

</html>