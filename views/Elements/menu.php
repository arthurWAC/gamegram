<?php
// Menu
$html->addMenu('Présentation', 
    ['dir' => 'games', 'page' => 'presentation']
);

$html->addMenu('Jeux', 
    ['dir' => 'games', 'page' => 'jeux']
);

if ($Auth->logged) {
    // $html->addMenu('Feed', 'feed.php');
    // $html->addMenu('Mes infos', 'profil.php');
    // $html->addMenu('Déconnexion', 'controllers.php?action=logout');
} else {
    $html->addMenu('Inscription', 
        ['dir' => 'users', 'page' => 'inscription']
    );
    $html->addMenu('Connexion', 
        ['dir' => 'users', 'page' => 'connexion']
    );
}

$html->setDisplayRecherche(false);