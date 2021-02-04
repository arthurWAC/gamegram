<?php
include('loader.php'); // Ma ligne de base sur chacun de mes fichiers

// Sécurité sur le fait d'être déjà connecté
if ($Auth->logged) {
	$Alert->setAlert('Tu es déjà connecté !', ['color' => WARNING]);
    $Alert->redirect('index.php');
}

$html = new Bootstrap('Inscription', 'Inscription '. NAME_APPLICATION .' !');

// Début du DOM HTML
echo $html->startDOM();

include('elements/menu.php');

echo $html->menu();

// Main
echo $html->startMain();
?>
<div class="starter-template text-center mt-5 px-3">
	<h1>Connexion</h1>
	<p class="lead">Welcome back !</p>
</div>

<div class="row justify-content-center">
	<div class="col col-sm-8 col-lg-4">
	<?php
	
	$form = new BootstrapForm('Connexion', 'controllers.php', METHOD_POST);

	$form->addInput('username',	TYPE_EMAIL, 	['label' => 'Adresse mail']);
	$form->addInput('password', TYPE_PASSWORD, 	['label' => 'Mot de passe']);

	$form->setSubmit('Je me connecte', ['color' => SUCCESS]);
	
	echo $form->form();
	?>
    <br /><hr />
    <p class="lead text-center">Pas encore de compte ?</p>
    <p class="text-center"><?= $html->button('inscription', 'inscription.php', ['color' => WARNING]); ?></p>
	</div>
</div>
<?php
echo $html->endMain();
echo $html->endDOM();