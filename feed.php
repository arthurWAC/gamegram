<?php
include('loader.php');

// Sécurité sur le fait d'être déjà connecté
if (!$Auth->logged) {
	$Alert->setAlert('Tu dois être connecté pour accéder à cette page !', ['color' => DANGER]);
    $Alert->redirect('connexion.php');
}

$html = new Bootstrap('Feed', 'Derniers posts de '. NAME_APPLICATION .' !');

// Début du DOM HTML
echo $html->startDOM();

include('elements/menu.php');

echo $html->menu();

// Main
echo $html->startMain();
?>
<div class="starter-template text-center mt-5 px-3">
	<h1 class="mb-3">Derniers posts</h1>
	<p class="text-center"><?= $html->button('+ Nouveau Post', 'new_post.php', ['color' => SUCCESS]); ?></p>
</div>

<div class="row justify-content-center mt-5">
	<div class="col col-sm-8">
	<?php
	$post = new Post();
	$posts = $post->lastPostsWithGameAndUser();
	foreach ($posts as $post): ?>
	<div class="card mb-5">
		<div class="card-header">
			<img src="assets/img/icons/Rating.svg" style="float: right; height: 24px;" />
			Le <?= date('d/m/Y', strtotime($post->created)); ?> par <?= $post->User->pseudo; ?>
		</div>
		<div class="card-body">
			<div class="row">
				<div class="col col-sm-8">
		    		<h5 class="card-title"><?= $post->title; ?></h5>
		    		<p class="card-text"><?= nl2br(html_entity_decode($post->content)) ;?></p>
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
	    <div class="card-footer mt-5">
	    	<?= $html->button('Voir le post', 'post.php?id=' . $post->id, ['color' => SUCCESS, 'class' => 'btn-sm']); ?>
	    </div>
	</div>
	<?php endforeach; ?>
	</div>
</div>

<?php
echo $html->endMain();
echo $html->endDOM();