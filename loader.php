<?php
// Démarrage de la session, pour utiliser $_SESSION
session_start();

// Constantes ------------------------
define('DIR_CONSTANTES', 'constantes' . DIRECTORY_SEPARATOR);
require(DIR_CONSTANTES . 'system.php');
require(DIR_CONSTANTES . 'bootstrap.php');
require(DIR_CONSTANTES . 'session.php');
// -----------------------------------

// Auto-load -------------------------
function loader($class)
{
    $folders = [DIR_MODELS, DIR_CONTROLLERS, DIR_UTILS];

    foreach ($folders as $folder) {
        $fileName = $folder . $class . '.php';

        if (file_exists($fileName)) {
            require($fileName);
            return true;
        }
    }

    return false;
}

spl_autoload_register('loader');
// -------------------------------------

// Instanciations par défaut de certains utilitaires ---------------
// Disponible partout dans toutes mes pages
$Design = new Design;
$Alert = new Alert;
$Auth = new Auth;
// -----------------------------------------------------------------