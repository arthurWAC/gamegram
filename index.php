<?php
include('loader.php');
// Ce nouveau fichier index il est plus lié au contexte de mon projet
// C'est un morceau de mon framework
// On va toujours rester sur index.php

// dir et page et valeur par défaut
$dir = $_GET['dir'] ?? 'Games'; // dir => model ?
$page = $_GET['page'] ?? 'accueil'; // page => view ?
// => $dir et $page utilisées dans Templates/front

// Appel dynamique de mes controllers ------------------------------------
$controller = ucfirst($dir) . 'ViewController'; // "GamesViewController"

// Sécurité 1 : Le controller existe
Router::controlFile(DIR_CONTROLLERS, $controller);

$call = new $controller; // new GamesViewController;

// Sécurité 2 : ma méthode existe
Router::controlMethod($controller, $page);

$data = $call->{$page}(); // accueil

// Array ( [title] => GameGram [description] => Un tout nouveau réseau ...)
// $_title = 'Gamegram';
// $_description = 'Un tout nouveau réseau ...';

foreach ($data as $name => $value) {
    $nameVariable = '_' . $name;
    ${$nameVariable} = $value;
}
// ------------------------------------------------------------------------

// Sécurité 3 : ma vue existe
Router::controlFile(DIR_VIEWS . $dir . DIRECTORY_SEPARATOR, $page);

include(DIR_VIEWS . 'Templates/front.php');