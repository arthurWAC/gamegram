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

$member = new User($_GET['id']);

if (!$member->exist()) {
	$Alert->setAlert('Ce Feed n\'existe pas');
	$Alert->redirect('feed.php');
}

$html = new Bootstrap($member->pseudo, 'Posts et Commentaires de ' . $member->pseudo);

// Début du DOM HTML
echo $html->startDOM();

include('elements/menu.php');

echo $html->menu();

// Main
echo $html->startMain();
?>
<div class="starter-template text-center mt-5 px-3">
	<h1 class="mb-3">Le feed de <?= $member->pseudo; ?></h1>
</div>

<div class="row justify-content-center mt-5">
	<div class="col col-sm-8">

    <?php
    $member->loadLastPostsAndComments();

    foreach ($member->LastPostsAndComments as $postOrComment) {

        if (is_a($postOrComment['data'], 'Post')) {
            $post = $postOrComment['data'];
            include('elements/post_seul.php');
        }

        if (is_a($postOrComment['data'], 'Comment')) {
            $comment = $postOrComment['data'];
            include('elements/comment_seul.php');
        }
    }

    // $member->loadLastPosts();
    // foreach ($member->Posts as $post) {
    //     include('elements/post_seul.php');
    // }

    // $member->loadLastComments();
    // foreach ($member->Comments as $comment) {
    //     include('elements/comment_seul.php');
    // }
    ?>
    </div>
</div>

<?php
echo $html->endMain();
echo $html->endDOM();