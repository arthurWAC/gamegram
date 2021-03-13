<div class="starter-template text-center mt-5 px-3">
	<h1>Recommandations de jeux</h1>
	<p class="lead">Tu vas surement aimer ces jeux que nous te proposons :</p>

</div>
<div class="row justify-content-center">
	<div class="col col-md-6">
		<?php foreach ($_games as $jeu): ?>

		<div class="card mb-2">
			<div class="card-body">
			<span class="badge bg-success float-end"><?= $jeu->year; ?></span>
				<h5 class="card-title"><?= ucfirst($jeu->name)?> </h5>
				<p class="card-text">Note du public : <strong><?= $jeu->note ;?></strong>/10</p>
				<?= $html->button(
					'Voir le jeu',
					[
						'dir' => 'games',
						'page' => 'one',
						'options' => ['id' => $jeu->id]
					],
					['color' => SUCCESS,'class' => 'btn-sm']
				); ?>
			</div>
		</div>

		<?php endforeach; ?>
	</div>
</div>