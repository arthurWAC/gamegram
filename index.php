<?php
include('loader.php'); // Ma ligne de base sur chacun de mes fichiers

$html = new Bootstrap('Accueil', 'Bienvenue sur '. NAME_APPLICATION .' !');

// Début du DOM HTML
echo $html->startDOM();

// Menu
include('elements/menu.php');

echo $html->menu();

// Main
echo $html->startMain();
?>
<div class="starter-template text-center py-5 px-3">
	<h1><?= NAME_APPLICATION; ?></h1>
	<p class="lead">Un tout nouveau réseau social<br />centré sur l'univers des jeux-vidéos Multijoueurs !</p>
	<p>
		<?= $html->image('manettes.jpg', ['alt' => 'Manettes de jeux vidéo', 'width' => '40%', 'class' => 'rounded']);?>
	</p>
	
	<p>
		<?= $html->button('Présentation', 'presentation.php');?>
		<?= $html->button('Je crée un compte', 'inscription.php', ['color' => SUCCESS]);?>
	</p>
	
</div>
<?php
echo $html->endMain();
echo $html->endDOM();