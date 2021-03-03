<div class="starter-template text-center mt-5 px-3">
	<h1>Mise à jour de mes informations</h1>
	<p class="lead">Laissez le mot de passe vide pour ne pas le changer</p>
</div>

<div class="row justify-content-center">
	<div class="col col-sm-8 col-lg-4">
	<?php
	
	$form = new BootstrapForm('Modification', 'User', METHOD_POST);

	$form->addInput('username',	TYPE_EMAIL, 	['value' => $Auth->User->username, 'label' => 'Adresse mail', 'placeholder' => 'Pour spammer ta boite mail chaque jour']);
	$form->addInput('password', TYPE_PASSWORD, 	['label' => 'Mot de passe', 'placeholder' => 'laissez vide pour ne pas le changer']);
	$form->addInput('pseudo', 	TYPE_TEXT, 		['value' => $Auth->User->pseudo, 'label' => 'Pseudo', 'placeholder' => 'Quelque chose d\'unique, qui te caractérise !']);
	$form->addInput('nb_jeux', 	TYPE_NUMBER, 	['value' => $Auth->User->nb_games, 'label' => 'Nombre de jeux', 'min' => 0, 'max' => 1000, 'step' => 1, 'placeholder' => 'Pour savoir quel joueur tu es']);
	
	$form->setSubmit('Mettre à jour', ['color' => SUCCESS]);
	
	echo $form->form();
	?>
    <br /><hr />
    <p class="lead text-center">Ton Feed ?</p>
    <p class="text-center"><?= $html->button(
		'Le feed de ' . $Auth->User->pseudo, 
		['dir' => 'posts', 'page' => 'user', 'options' => ['id' => $Auth->User->id]],
		['color' => WARNING]
	); ?></p>

<p class="text-center"><?= $html->button(
		'Les commentaires de ' . $Auth->User->pseudo,
		['dir' => 'comments', 'page' => 'user', 'options' => ['id' => $Auth->User->id]],
		['color' => WARNING]
	); ?></p>
    </div>
</div>