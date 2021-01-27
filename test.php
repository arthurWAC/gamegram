<?php
require('loader.php');

// Tests manuels
$game = new Game(3);

echo 'Le jeu ' . $game->id . ' se nomme ' . $game->name . 
'<br />se joue sur ' . $game->Platform->name . 
'<br />est du genre ' . $game->Family->name . 
'<br />produit par ' . $game->Publisher->name;
die;



// Le compte des éléments
echo 'Il y a ' . $orm->get('count') . ' jeux dans la base';

// Un élément
echo '<pre>';
print_r($orm->get('all'));
echo '</pre>';


// Autres requêtes que SELECT
/*
$orm = new ORM();
$orm->setSQL('UPDATE games SET score = 9 WHERE score >= 8.5');
$orm->launch();

// Temps 2 :

*/

