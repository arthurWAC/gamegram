<?php
include('loader.php'); // Ma ligne de base sur chacun de mes fichiers

$html = new Bootstrap('Jeux', 'Les jeux de '. NAME_APPLICATION .' !');

// Début du DOM HTML
echo $html->startDOM();

// Menu
$html->addMenu('Présentation', 'presentation.php');
$html->addMenu('Jeux', 'jeux.php');
$html->addMenu('Inscription', 'inscription.php');
$html->setDisplayRecherche(false);

echo $html->menu();

// Main
echo $html->startMain();
?>
<div class="starter-template text-center py-5 px-3">
	<h1>Liste des jeux</h1>
</div>
<?php
echo $html->endMain();
echo $html->endDOM();