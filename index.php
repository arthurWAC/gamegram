<?php
include('loader.php');
// Ce nouveau fichier index il est plus lié au contexte de mon projet
// C'est un morceau de mon framework
// On va toujours rester sur index.php

// dir et page et valeur par défaut
$dir = $_GET['dir'] ?? 'Games';
$page = $_GET['page'] ?? 'accueil';
// => $dir et $page utilisées dans Templates/front

// Appel dynamique de mes controllers ------------------------------------
$controller = ucfirst($dir) . 'Controller'; // "GamesController"
$method = 'view_' . $page; // "view_accueil"

$call = new $controller; // new GamesController;
$data = $call->{$method}();

// Array ( [title] => GameGram [description] => Un tout nouveau réseau ...)
// $_title = 'Gamegram';
// $_description = 'Un tout nouveau réseau ...';

foreach ($data as $name => $value) {
    $nameVariable = '_' . $name;
    ${$nameVariable} = $value;
}
// ------------------------------------------------------------------------

include(DIR_VIEWS . 'Templates/front.php');