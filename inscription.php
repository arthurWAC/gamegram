<?php
include('loader.php'); // Ma ligne de base sur chacun de mes fichiers

$html = new Bootstrap('Inscription', 'Inscription '. NAME_APPLICATION .' !');

// Début du DOM HTML
echo $html->startDOM();

// Menu
$html->addMenu('Présentation', 'presentation.php');
$html->addMenu('Jeux', 'jeux.php');
$html->addMenu('Inscription', 'inscription.php');
$html->setDisplayRecherche(false);

echo $html->menu();

// Main
echo $html->startMain();
?>
<div class="starter-template text-center py-5 px-3">
	<h1>Inscription</h1>
	<p class="lead">Merci de remplir le formulaire ci-dessous.</p>
	<?php
	
	$form = new BootstrapForm('Inscription', 'inscription.php', METHOD_POST);
	
	$form->addInput('username', TYPE_TEXT, ['label' => 'Adresse mail']);
	$form->addInput('password', TYPE_PASSWORD, ['label' => 'Mot de passe']);
	$form->addInput('pseudo', TYPE_TEXT, ['label' => 'Pseudo']);
	$form->addInput('nb_jeux', TYPE_NUMBER, ['label' => 'Nombre de jeux']);
	
	$form->setSubmit('Je m\'inscris', ['color' => SUCCESS]);
	
	echo $form->form();
	?>
</div>
<?php
echo $html->endMain();
echo $html->endDOM();