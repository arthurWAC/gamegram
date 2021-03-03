<div class="starter-template py-5 px-3">
	<h1 class="text-center"><?= $_jeu->name; ?></h1>
</div>
<div class="row justify-content-center">
	<div class="col col-md-8">

		<div class="card mb-2">
			<div class="card-body">
				<p>Famille : <?= $html->badge($_jeu->Family->name) ;?></p>
				<p>Plateforme : <?= $html->badge($_jeu->Platform->name, ['color' => WARNING]); ?></p>
				<p>Editeur : <?= $html->badge($_jeu->Publisher->name); ?></p>
			</div>
		</div>

		<p>
		<?= $html->button(
			'&larr; Retour',
			['dir' => 'games', 'page' => 'all'],
			['color' => 'light']); ?>
		</p>
	</div>
</div>