<div class="starter-template text-center mt-5 px-3">
	<h1 class="mb-3"><?= $_post->title; ?></h1>
</div>

<div class="row justify-content-center mt-5">
	<div class="col col-sm-6">
		<p class="card-text"><?= $html->toHtml($_post->content) ;?></p>

		<?php if ($_post->nbComments != 0): ?>
			<br /><hr />
			<h4 class="mb-3"><?= $_post->nbComments; ?> Commentaire(s)</h4>
			<?php
			foreach ($_post->Comments as $comment):
			?>
			<div class="card mb-3">
				<div class="card-header small">
					Le <?= date('d/m/Y', strtotime($comment->created)); ?> par <?= $comment->User->pseudo; ?>
				</div>
				<div class="card-body small">
					<p><?= $comment->content ;?></p>
				</div>
			</div>
			<?php endforeach; ?>
		<?php endif; ?>

		<br /><hr />
		<h4>Laisse un commentaire !</h4>
		<?php
		$form = new BootstrapForm('Nouveau Commentaire', 'Comment', METHOD_POST);

	    $form->addInput('post_id', TYPE_HIDDEN, ['value' => $_post->id]);
	    $form->addInput('content', 	TYPE_TEXTAREA, 	['label' => 'Ton commentaire', 'rows' => 8, 'class' => 'summernote']);
		
		$form->setSubmit('Je commente', ['color' => SUCCESS]);
		
		echo $form->form();
		?>
	</div>
	<div class="col col-md-2">
		<div class="card">
			<div class="card-body text-center">
				<h6 class="card-title"><?= $_post->Game->name; ?></h6>
				<img src="<?= $Design->icon($_post->Game->family_id); ?>" />
				<span class="badge bg-success"><?= $_post->Game->Family->name; ?></span> - <span class="badge bg-success"><?= $_post->Game->Platform->name; ?></span>
			</div>
		</div>

		<br />

		<p class="text-center">
			<?= $html->button('&larr; Retour au feed', ['dir' => 'posts', 'page' => 'feed'], ['color' => LIGHT]); ?>
		</p>
	</div>
</div>