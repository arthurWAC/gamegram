<div class="starter-template text-center mt-5 px-3">
	<h1>Nouveau Post</h1>
    <p class="lead">Complète le formulaire ci-dessous pour partager une news, lancer une discussion, donner ton avis, etc.</p>
</div>

<div class="row justify-content-center">
	<div class="col col-sm-8">
	<?php
    $form = new BootstrapForm('Nouveau Post', 'Post', METHOD_POST);

    // $form->addInput('user_id', TYPE_HIDDEN, ['value' => $Auth->User->id]);
	$form->addInput('title',	TYPE_TEXT, 	['label' => 'Titre', 'placeholder' => 'Pour décrire de quoi tu parle']);
    
    // A coder dans BootstrapForm
    $form->addInput('game_id', TYPE_SELECT, ['label' => 'Jeu associé', 'data' => $_gamesById, 'class' => 'select2']);

    // A coder dans BootstrapForm
    $form->addInput('content', 	TYPE_TEXTAREA, 	['label' => 'Contenu', 'rows' => 8, 'class' => 'summernote']);
	
	$form->setSubmit('Je publie', ['color' => SUCCESS]);
	
	echo $form->form();
	?>
	</div>
</div>