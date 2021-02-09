<?php
// Démarrage de la session, pour utiliser $_SESSION
session_start();

// Composer
// require('vendor/autoload.php');

// Constantes
require('constantes.php');

// ORM et Modèles
require(DIR_MODELS . 'ORM.php');
require(DIR_MODELS . 'Validator.php');

require(DIR_MODELS . 'Game.php');
require(DIR_MODELS . 'Platform.php');
require(DIR_MODELS . 'Publisher.php');
require(DIR_MODELS . 'Family.php');
require(DIR_MODELS . 'User.php');
require(DIR_MODELS . 'Post.php');
require(DIR_MODELS . 'Comment.php');

// Utils
require(DIR_UTILS . 'Bootstrap.php');
require(DIR_UTILS . 'BootstrapForm.php');
require(DIR_UTILS . 'BootstrapAlert.php');

require(DIR_UTILS . 'Design.php');
$Design = new Design; // Disponible partout dans toutes mes pages


require(DIR_UTILS . 'Alert.php');
$Alert = new Alert; // Disponible partout dans toutes mes pages

require(DIR_UTILS . 'Auth.php');
$Auth = new Auth; // Disponible partout dans toutes mes pages