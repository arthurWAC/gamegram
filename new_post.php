<?php
include('loader.php');

// Sécurité sur le fait d'être déjà connecté
if (!$Auth->logged) {
	$Alert->setAlert('Tu dois être connecté pour accéder à cette page !', ['color' => DANGER]);
    $Alert->redirect('connexion.php');
}

$html = new Bootstrap('+ Post', 'Nouveau Post pour '. NAME_APPLICATION .' !');

// Début du DOM HTML
echo $html->startDOM();

include('elements/menu.php');

echo $html->menu();

// Main
echo $html->startMain();
?>
<div class="starter-template text-center mt-5 px-3">
	<h1>Nouveau Post</h1>
    <p class="lead">Complète le formulaire ci-dessous pour partager une news, lancer une discussion, donner ton avis, etc.</p>
</div>

<div class="row justify-content-center">
	<div class="col col-sm-8">
	<?php

    // Construire $gamesById
    // ['1' => 'Wii Sports', '5' => 'Wii Sports Resorts']
    // 1. Récupérer les données via Game
    // 2. Reconstruire le tableau (dans Game)
    $game = new Game();
    $gamesById = $game->publicGamesById();
	
	$form = new BootstrapForm('Nouveau Post', 'controllers.php', METHOD_POST);

    // $form->addInput('user_id', TYPE_HIDDEN, ['value' => $Auth->User->id]);
	$form->addInput('title',	TYPE_TEXT, 	['label' => 'Titre', 'placeholder' => 'Pour décrire de quoi tu parle']);
    
    // A coder dans BootstrapForm
    $form->addInput('game_id', TYPE_SELECT, ['label' => 'Jeu associé', 'data' => $gamesById, 'class' => 'select2']);

    // A coder dans BootstrapForm
    $form->addInput('content', 	TYPE_TEXTAREA, 	['label' => 'Contenu', 'rows' => 8, 'class' => 'summernote']);
	
	$form->setSubmit('Je publie', ['color' => SUCCESS]);
	
	echo $form->form();
	?>
	</div>
</div>

<?php
echo $html->endMain();
echo $html->endDOM();