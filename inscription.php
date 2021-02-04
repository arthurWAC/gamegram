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

// Menu
include('elements/menu.php');

echo $html->menu();

// Main
echo $html->startMain();
?>
<div class="starter-template text-center mt-5 px-3">
	<h1>Inscription</h1>
	<p class="lead">Merci de remplir le formulaire ci-dessous.</p>
</div>

<div class="row justify-content-center">
	<div class="col col-sm-8 col-lg-4">
	<?php
	
	$form = new BootstrapForm('Inscription', 'controllers.php', METHOD_POST);

	$form->addInput('username',	TYPE_EMAIL, 	['label' => 'Adresse mail', 'placeholder' => 'Pour spammer ta boite mail chaque jour']);
	$form->addInput('password', TYPE_PASSWORD, 	['label' => 'Mot de passe', 'placeholder' => '8 caractères minimum']);
	$form->addInput('pseudo', 	TYPE_TEXT, 		['label' => 'Pseudo', 'placeholder' => 'Quelque chose d\'unique, qui te caractérise !']);
	$form->addInput('nb_jeux', 	TYPE_NUMBER, 	['label' => 'Nombre de jeux', 'min' => 0, 'max' => 1000, 'step' => 1, 'placeholder' => 'Pour savoir quel joueur tu es']);
	
	$form->setSubmit('Je m\'inscris', ['color' => SUCCESS]);
	
	echo $form->form();
	?>
    <hr />
    <p class="lead text-center">Déjà inscrit ?</p>
    <p class="text-center"><?= $html->button('Connexion', 'connexion.php', ['color' => WARNING]); ?></p>
	</div>
</div>
<?php
echo $html->endMain();
echo $html->endDOM();