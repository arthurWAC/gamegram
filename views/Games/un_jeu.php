<?php
include('loader.php'); // Ma ligne de base sur chacun de mes fichiers

if (!is_numeric($_GET['id'])) {
	$Alert->setAlert('Mauvais format de "id"');
	$Alert->redirect('jeux.php');
}

// Affichage d'un seul jeu
// Je vais récupérer l'id du jeu depuis une variable GET
// $_GET['id']
$jeu = new Game($_GET['id']);

if (!$jeu->exist()) {
	$Alert->setAlert('Ce jeu n\'existe pas');
	$Alert->redirect('jeux.php');
}

$html = new Bootstrap('Jeux', $jeu->name);

// Début du DOM HTML
echo $html->startDOM();

// Menu
include('elements/menu.php');

echo $html->menu();

// Main
echo $html->startMain();
?>
<div class="starter-template py-5 px-3">
	<h1 class="text-center"><?= $jeu->name; ?></h1>
</div>
<div class="row justify-content-center">
	<div class="col col-md-8">

		<div class="card mb-2">
			<div class="card-body">
				<p>Famille : <?= $html->badge($jeu->Family->name) ;?></p>
				<p>Plateforme : <?= $html->badge($jeu->Platform->name, ['color' => WARNING]); ?></p>
				<p>Editeur : <?= $html->badge($jeu->Publisher->name); ?></p>
			</div>
		</div>

		<p>
		<?= $html->button('&larr; Retour', 'jeux.php', ['color' => 'light']); ?>
		</p>
	</div>
</div>
<?php
echo $html->endMain();
echo $html->endDOM();