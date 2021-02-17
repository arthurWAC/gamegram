<div class="card mb-5" id="post_<?= $post->id; ?>">
		<div class="card-header">

			<div class="row">
				<div class="col-8">
					Le <?= date('d/m/Y', strtotime($post->created)); ?> par 
					<a href="feed_user.php?id=<?= $post->User->id; ?>">
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
					$form = new BootstrapForm('Unlike', 'controllers.php', METHOD_POST);

				    $form->addInput('post_id', TYPE_HIDDEN, ['value' => $post->id]);
					$form->setSubmit('Unlike', ['color' => WARNING, 'class' => 'btn-sm float-end']);
					
					echo $form->form();
				} else {
					// Post non liké, bouton "like"
					$form = new BootstrapForm('Nouveau Like', 'controllers.php', METHOD_POST);

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
    </div>

	   