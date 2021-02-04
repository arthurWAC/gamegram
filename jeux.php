<?php
include('loader.php'); // Ma ligne de base sur chacun de mes fichiers

$html = new Bootstrap('Jeux', 'Les jeux de '. NAME_APPLICATION .' !');

// Début du DOM HTML
echo $html->startDOM();

// Menu
include('elements/menu.php');

echo $html->menu();

// Main
echo $html->startMain();
?>
<div class="starter-template text-center mt-5 px-3">
	<h1>Liste des jeux</h1>
	<p class="lead">Découvre la liste de jeux disponibles dans <?= NAME_APPLICATION ?> ! </p>
</div>
<div class="row justify-content-center">
	<div class="col col-md-6">
	<?php
	// Connexion à ma base de données
	$game = new Game();

	$listOfGames = $game->listOfPublicGames();
	?>
	<p class="lead text-center mb-5">Il y a actuellement <strong><?= count($listOfGames); ?></strong> jeux dans la base de données</p>
		<?php foreach ($listOfGames as $jeu): ?>

		<div class="card mb-2">
			<div class="card-body">
			<span class="badge bg-success float-end"><?= $jeu->year; ?></span>
				<h5 class="card-title"><?= ucfirst($jeu->name)?> </h5>
				<p class="card-text">Note du public : <strong><?= $jeu->note ;?></strong>/10</p>
				<?= $html->button('Voir le jeu', 'un_jeu.php?id=' . $jeu->id, ['color' => SUCCESS, 'class' => 'btn-sm']); ?>
			</div>
		</div>

		<?php endforeach; ?>
	</div>
</div>
<?php
echo $html->endMain();
echo $html->endDOM();