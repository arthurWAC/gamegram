<div class="starter-template text-center mt-5 px-3">
	<h1 class="mb-3">Derniers posts</h1>
	<p class="text-center"><?= $html->button(
		'+ Nouveau Post',
		['dir' => 'posts', 'page' => 'create'],
		['color' => SUCCESS]
	); ?></p>
</div>

<div class="row justify-content-center mt-5">
	<div class="col col-sm-8">
	<?php
	foreach ($_posts as $post): ?>
	<div class="card mb-5" id="post_<?= $post->id; ?>">
		<div class="card-header">

			<div class="row">
				<div class="col-8">
					Le <?= date('d/m/Y', strtotime($post->created)); ?> par 
					<a href="<?= Router::urlView('posts', 'user', ['id' => $post->User->id]); ?>">
						<?= $post->User->pseudo; ?>
					</a>
				</div>
				<div class="col-2">
					<?= $post->nbLikes; ?> 
					<img src="assets/img/icons/Rating.svg" style="height: 24px;" />
				</div>
				<div class="col-2">
				<?php
				// Like ou pas
				if ($post->liked) {
					// Post liké, bouton "unlike"
					$form = new BootstrapForm('Unlike', 'Like', METHOD_POST);

				    $form->addInput('post_id', TYPE_HIDDEN, ['value' => $post->id]);
					$form->setSubmit('Unlike', ['color' => WARNING, 'class' => 'btn-sm float-end']);
					
					echo $form->form();
				} else {
					// Post non liké, bouton "like"
					$form = new BootstrapForm('Nouveau Like', 'Like', METHOD_POST);

				    $form->addInput('post_id', TYPE_HIDDEN, ['value' => $post->id]);
					$form->setSubmit('Like', ['color' => SUCCESS, 'class' => 'btn-sm float-end']);
					
					echo $form->form();
				}
				?>
				</div>
			</div>
			
		</div>
		<div class="card-body">
			<div class="row">
				<div class="col col-sm-8">
		    		<h5 class="card-title"><?= $post->title; ?></h5>
		    		<p class="card-text"><?= $html->toHtml($post->content) ;?></p>
		    	</div>
				<div class="col col-sm-4">
					<div class="card">
						<div class="card-body text-center">
							<h6 class="card-title"><?= $post->Game->name; ?></h6>
							<img src="<?= $Design->icon($post->Game->family_id); ?>" />
							<span class="badge bg-success"><?= $post->Game->Family->name; ?></span> - <span class="badge bg-success"><?= $post->Game->Platform->name; ?></span>
						</div>
					</div>
				</div>
		    </div>
	    </div>

	    <div class="card mx-3">
			<div class="card-header">
				<h6 class="card-title">Commentaire(s)</h6>
			</div>
			<div class="card-body">
		    <?php

		    if ($post->nbComments == 0) {
		    	echo '<p>Pas encore de commentaire.</p>';
		    }

		    foreach ($post->Comments as $comment):
			?>
			<p><b><?= $comment->User->pseudo; ?></b> : <?= $comment->content ;?></p>
			<?php endforeach; 

			if ($post->nbComments > 2) {
				echo '<p>' . ($post->nbComments - 2) . ' autre(s) commentaire(s).</p>';
			}

			?>
			</div>
		</div>

	    <div class="card-footer mt-3">
	    	<?= $html->button(
				'Voir le post',
				['dir' => 'posts', 'page' => 'one', 'options' => ['id' => $post->id]],
				['color' => SUCCESS, 'class' => 'btn-sm']); ?>
	    </div>
	</div>
	<?php endforeach; ?>
	</div>
</div>