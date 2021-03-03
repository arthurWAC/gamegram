<?php
include('loader.php');
// Ce nouveau fichier process il n'est pas lié au contexte de mon projet
// C'est un morceau de mon framework
// Ce sera l'atterissage des formulaires, là où se lance les process, les traitements (de données)

// dir et page (pas de process par défaut)
$dir = $_GET['dir'] ?? ''; // dir => model
$page = $_GET['page'] ?? ''; // page => process

// Appel dynamique de mes controllers ------------------------------------
$controller = ucfirst($dir) . 'ProcessController'; // "UsersProcessController"

// Sécurité 1 : Le controller existe
Router::controlFile(DIR_CONTROLLERS, $controller);
$call = new $controller; // new UsersProcessController;

// Sécurité 2 : ma méthode existe
Router::controlMethod($controller, $page);
$data = $call->{$page}(); // inscription