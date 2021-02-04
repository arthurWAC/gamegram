<?php
require('loader.php'); // Ma ligne de base sur chacun de mes fichiers

$html = new Bootstrap('Présentation', 'Présentation de '. NAME_APPLICATION .' !');

// Début du DOM HTML
echo $html->startDOM();

// Menu
include('elements/menu.php');

echo $html->menu();

// Main
echo $html->startMain();
?>
<div class="starter-template text-center py-5 px-3">
	<h1>Présentation de <?= NAME_APPLICATION; ?></h1>
	<p class="lead">I love cheese, especially brie queso. Monterey jack jarlsberg roquefort say cheese chalk and cheese dolcelatte halloumi danish fontina. Pecorino edam fromage frais hard cheese rubber cheese dolcelatte fromage frais halloumi. Cheese strings danish fontina cheese and biscuits cheese slices queso boursin port-salut say cheese. Croque monsieur cheddar cheese slices fromage frais ricotta smelly cheese cheese and biscuits mascarpone. Cottage cheese cut the cheese monterey jack mozzarella cheeseburger monterey jack halloumi.</p>
	<p class="lead">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
	<p class="lead">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
	<p class="lead">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
	<p class="lead">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
	
</div>
<?php
echo $html->endMain();
echo $html->endDOM();