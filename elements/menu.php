<?php
// Menu
$html->addMenu('Présentation', 'presentation.php');
$html->addMenu('Jeux', 'jeux.php');

if ($Auth->logged) {
    $html->addMenu('Feed', 'feed.php');
    $html->addMenu('Mes infos', 'profil.php');
    $html->addMenu('Déconnexion', 'controllers.php?action=logout');
} else {
    $html->addMenu('Inscription', 'inscription.php');
    $html->addMenu('Connexion', 'connexion.php');
}

$html->setDisplayRecherche(false);