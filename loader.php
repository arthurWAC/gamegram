<?php
// Démarrage de la session, pour utiliser $_SESSION
session_start();

// Constantes
require('constantes.php');

// ORM et Modèles
require(DIR_MODELS . 'ORM.php');
require(DIR_MODELS . 'Game.php');
require(DIR_MODELS . 'Platform.php');
require(DIR_MODELS . 'Publisher.php');
require(DIR_MODELS . 'Family.php');

// Utils
require(DIR_UTILS . 'Bootstrap.php');
require(DIR_UTILS . 'BootstrapForm.php');
require(DIR_UTILS . 'BootstrapAlert.php');

require(DIR_UTILS . 'Alert.php');
$Alert = new Alert; // Disponible partout dans toutes mes pages