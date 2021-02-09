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
	<h1>Derniers posts</h1>
	<p class="text-center"><?= $html->button('+ Nouveau Post', 'new_post.php', ['color' => SUCCESS]); ?></p>
</div>

<?php

$post = new Post();
$posts = $post->lastPosts();

echo '<pre>';
print_r($posts);
echo '</pre>';
?>


<?php
echo $html->endMain();
echo $html->endDOM();