<?php
include('loader.php');

// Sécurité sur le fait d'être déjà connecté
if (!$Auth->logged) {
	$Alert->setAlert('Tu dois être connecté pour accéder à cette page !', ['color' => DANGER]);
    $Alert->redirect('connexion.php');
}

// Sécurité sur la présence de $_GET['id'] et sur le fait que $_GET['id'] soit bien un nombre
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
	$Alert->setAlert('Attention à comment tu navigue sur nos pages', ['color' => DANGER]);
    $Alert->redirect('feed.php');
}

$post = new Post($_GET['id']);

if (!$post->exist()) {
	$Alert->setAlert('Ce Post n\'existe pas');
	$Alert->redirect('feed.php');
}

$html = new Bootstrap($post->title, substr($post->content, 0, 240) . '...');

// Début du DOM HTML
echo $html->startDOM();

include('elements/menu.php');

echo $html->menu();

// Main
echo $html->startMain();
?>
<div class="starter-template text-center mt-5 px-3">
	<h1 class="mb-3"><?= $post->title; ?></h1>
</div>

<div class="row justify-content-center mt-5">
	<div class="col col-sm-6">
		<p class="card-text"><?= $html->toHtml($post->content) ;?></p>
		<br /><hr />
		<h4 class="mb-3">Commentaire(s)</h4>
		<?php
		$comment = new Comment();

		$comments = $comment->commentsFromPost($post->id);
		foreach ($comments as $comment):
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

		<br /><hr />
		<h4>Laisse un commentaire !</h4>
		<?php
		$form = new BootstrapForm('Nouveau Commentaire', 'controllers.php', METHOD_POST);

	    $form->addInput('post_id', TYPE_HIDDEN, ['value' => $post->id]);
	    $form->addInput('content', 	TYPE_TEXTAREA, 	['label' => 'Ton commentaire', 'rows' => 8, 'class' => 'summernote']);
		
		$form->setSubmit('Je commente', ['color' => SUCCESS]);
		
		echo $form->form();
		?>
	</div>
	<div class="col col-md-2">
		<div class="card">
			<div class="card-body text-center">
				<h6 class="card-title"><?= $post->Game->name; ?></h6>
				<img src="<?= $Design->icon($post->Game->family_id); ?>" />
				<span class="badge bg-success"><?= $post->Game->Family->name; ?></span> - <span class="badge bg-success"><?= $post->Game->Platform->name; ?></span>
			</div>
		</div>

		<br />

		<p class="text-center">
			<?= $html->button('&larr; Retour au feed', 'feed.php', ['color' => LIGHT]); ?>
		</p>
	</div>
</div>
<?php
echo $html->endMain();
echo $html->endDOM();