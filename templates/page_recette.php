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
	<link rel="stylesheet" type="text/css" href="css/page_recette.css" />
</head>
<!-- **** F I N **** H E A D **** -->


<!-- **** B O D Y **** -->

<body>


	<div id="corps">
		<?php
		$idRecette = valider("id_page_recette");
		if (!$idRecette) {
			// pas d'identifiant ! On redirige vers la page accueil
		
			header("Location:index.php?view=accueil");
			die("idpage_recette manquant");
		}

		$titre = titre_recette($idRecette);
		echo "<div id='titre'>" . $titre . "</div>";
		$photopres = image_recette($idRecette, 1);
		echo "<div id='image'> <img src=" . $photopres . "></div>";
		$tempsPrep = tempsPreparation($idRecette);
		if (substr($tempsPrep, 0, 3) === "00:") {
			$tempsPrep = substr($tempsPrep, 3);
		}
		echo "<div class='tempsPrep'> <img src ='ressources/tempsPrep.png'> </div> <div class='prep'> Préparation ";
		echo $tempsPrep . " minutes </div></br></br>";
		$tempsCuis = tempsCuisson($idRecette);
		if (substr($tempsCuis, 0, 3) === "00:") {
			$tempsCuis = substr($tempsCuis, 3);
		}
		echo "<div class='tempsPrep'> <img src ='ressources/tempsCuiss.png'></div> <div class='prep'>  Cuisson ";
		echo $tempsCuis . " minutes </div>";
		$note = note($idRecette);
		echo "<div id='etoile'> <div id='avis'> Laisse ton avis ! <a href='index.php?view=avis&id_page_recette=$idRecette'> <img src='ressources/avis.png'> </a> </div> </br> ";
		for ($i = 0; $i < 5; $i++) {
			if ($i < $note) {
				echo "<img src='ressources/etoile.png' alt='etoile'>";
			} else {
				echo "<img src='ressources/etoileVide.png' alt='etoile' >";
			}
		}

		echo "</div> <div id='note'>" . $note . "/5 </div>";


		//adapter le nb de personnes et les quantités... 
		$listeIngredients = Liste_ingredients($idRecette);
		echo "</br></br> </br> </br> </br> </br> </br> </br>  <div class='titreElmt'> LES INGRÉDIENTS : </div> ";
		echo "pour 2 personnes </br> </br>";
		?>

		<div id="contenu">
			<div id="ingredient">
				<div id="imageIngredients">

					<?php $photoingr1 = image_recette($idRecette, 2);
					$photoingr2 = image_recette($idRecette, 3);
					echo "<img src='" . $photoingr1 . "'/>";
					if ($photoingr2 != NULL)
						echo "<img src='" . $photoingr2 . "'/>"; ?>
				</div>
				<div id='quantite'>


					<?php
					foreach ($listeIngredients as $val) {
						echo $val['quantite'] . " " . $val['unite_universelle'] . " " . $val['nom'] . "</br>";
					}
					?>
				</div>
			</div>
		</div>
		<?php

		$liste_etape = liste_etapes($idRecette);
		echo "</br> </br> <div class='titreElmt'> LES ETAPES : </div>";
		echo "<div id='etapes'>";
		//permet de recuperer chaque etape (on separe chaque chiffre suivi d'un point en le mettant à la ligne).
		$phrases = explode(". ", $liste_etape);
		foreach ($phrases as $phrase) {
			if (preg_match('/^\d+\./', $phrase)) {
				echo $phrase . "<br>";
			} else {
				echo $phrase . ". ";
			}
		}
		echo "</div>";


		echo "<div id='fin'>";
		$photofinal = image_recette($idRecette, 4);
		echo "<img src='" . $photofinal . "'/>";


		$avis = liste_avis($idRecette);
		$j = 1;
		echo '<div class="container">';
		foreach ($avis as $val) {
			if ($j > 2) {
				break;
			} else {
				echo "<div class='avis" . $j . "'>" . $val['titre'] . "</br></br> " . $val['texte_avis'] . "</br> </br>" . $val['pseudo'] . "</div>";
				$j++;
			}
		}

		echo "</div>";
		echo "</div>";



		if (isset($_SESSION['idUser'])) {
			$sessionIdPers = $_SESSION['idUser'];
			$fav = isFavoris($sessionIdPers, $idRecette);
			echo "<div id='Aj_fav'>
        <form action='controleur.php' method='GET'>
                <div class='infos'><input type='hidden' id='idUser' name='idUser' value=" . $sessionIdPers . " required /></div><br />
        <div class='log'>
        <input type='hidden' id='idRecette' name='idRecette' value='$idRecette' required />
    </div><br />";
			if ($fav != NULL) {
				echo "
    <input type='submit' name='action' value='Supprimer des favoris' id='favoris-button' />";

			} else {
				echo "
        <input type='submit' name='action' value='Ajouter aux favoris' id='favoris-button' />";
			}
			echo "</form>";
		}
		?>
</body>
<!-- **** F I N **** B O D Y **** -->

</html>