<div class="starter-template text-center mt-5 px-3">
	<h1>Connexion</h1>
	<p class="lead">Welcome back !</p>
</div>

<div class="row justify-content-center">
	<div class="col col-sm-8 col-lg-4">
	<?php
	
	$form = new BootstrapForm('Connexion', 'User', METHOD_POST);

	$form->addInput('username',	TYPE_EMAIL, 	['label' => 'Adresse mail']);
	$form->addInput('password', TYPE_PASSWORD, 	['label' => 'Mot de passe']);

	$form->setSubmit('Je me connecte', ['color' => SUCCESS]);
	
	echo $form->form();
	?>
    <br /><hr />
    <p class="lead text-center">Pas encore de compte ?</p>
    <p class="text-center"><?= $html->button('inscription', ['dir' => 'users', 'page' => 'inscription'], ['color' => WARNING]); ?></p>
	</div>
</div>