<?php
require('loader.php');




$post = new Post();

$posts = $post->lastPosts();
echo '<pre>';
print_r($posts);
echo '</pre>';
/*


$faker = Faker\Factory::create('fr_FR');


// user de 7 à 102
// game de 1 à 500
for ($i = 0; $i < 100; $i++) {
    $userId = rand(7, 102);
    $gameId = rand(1, 500);
    $title = $faker->sentence;
    $content = '<p>' . $faker->text . '</p><p>' . $faker->text . '</p>';

    $post->create($userId, $gameId, $title, $content);
}
*/

/*
$faker = Faker\Factory::create('fr_FR');

$user = new User;
// On va créer 100 users au hasard
for ($i = 0; $i < 100; $i++) {

    $username = $faker->email;
    $password = md5($username);
    $pseudo = $faker->username;
    $nbJeux = rand(10, 25);

    $user->create($username, $password, $pseudo, $nbJeux);
}
*/

/*
echo '<pre>';
print_r($_SESSION);
echo '</pre>';

if ($Auth->logged) {
    // Si je suis connecté
    echo 'Je suis ' . $Auth->User->pseudo;
}
*/

/*
$user = new User(2);
echo '<pre>';
print_r($user);
echo '</pre>';
unset($user);
echo '<pre>';
print_r($user);
echo '</pre>';


$pass = 'azerty';
echo $pass . ' : ' . md5($pass);

echo '<br />';

$pass = 'azerty';
echo $pass . ' : ' . md5($pass);

echo '<br />';

$pass = 'bonjour';
echo $pass . ' : ' . md5($pass);
// présence d'une lettre
// présence d'un chiffre
// présence d'un caractère spécial : *+-()[]{}$!.?=
    
$pass = [
    ['pass' => '', 'ok' => false],
    ['pass' => 'aaa', 'ok' => false],
    ['pass' => 'abc', 'ok' => false],
    ['pass' => 'a3a', 'ok' => false],
    ['pass' => 'a65', 'ok' => false],
    ['pass' => 'a6+', 'ok' => true],
    ['pass' => '8*d', 'ok' => true],
    ['pass' => '-erze48644', 'ok' => true],
    ['pass' => '48644zrih(]', 'ok' => true],
    ['pass' => '64664864687', 'ok' => false],
    ['pass' => '-*+-*--+*-', 'ok' => false],
    ['pass' => '-98etht54-+*-', 'ok' => true],
    ['pass' => '()684gerge)*-', 'ok' => true],

    ['pass' => '()6%4gerge)*-', 'ok' => false],
    ['pass' => '()684__rge)*-', 'ok' => false],
    ['pass' => '%__%_', 'ok' => false],

    ['pass' => '-98FGIYFZ54-+*-', 'ok' => true],
    ['pass' => '-98éèéèé54-+*-', 'ok' => true], // ??
];

foreach ($pass as $p) {
    $validator = new Validator($p, 'url');

    if ($validator->validatePassword('pass', 3) === $p['ok']) {
        echo '<p style="color: green;">Test OK</p>';
    } else {
        echo '<p style="color: red;">Test KO</p>';
    }
}*/