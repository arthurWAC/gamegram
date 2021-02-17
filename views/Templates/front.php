<?php
$html = new Bootstrap($_title, $_description);

// Début du DOM HTML
echo $html->startDOM();

// Menu
include(DIR_VIEWS . 'Elements/menu.php');

echo $html->menu();

// Main
echo $html->startMain();

// Ma page
include(DIR_VIEWS . $dir . DIRECTORY_SEPARATOR . $page . '.php');

echo $html->endMain();
echo $html->endDOM();