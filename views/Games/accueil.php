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