<?php
include('loader.php'); // Ma ligne de base sur chacun de mes fichiers

// Affichage d'un seul jeu
// Je vais récupérer l'id du jeu depuis une variable GET
// $_GET['id']

// Requête préparée, avec la méthode "bindValue"

// Connexion à ma base de données
$db = new PDO('mysql:host=localhost;dbname=gamegram', 'root', '');

// J'écris ma requête
$sql = 'SELECT name, note, year, family_id, platform_id, publisher_id';
$sql .= ' FROM games';
$sql .= ' WHERE id = :id';

// Je prépare ma requête
$query = $db->prepare($sql);
$query->bindValue(':id', $_GET['id'], PDO::PARAM_INT); // Sécurité contre les injections SQL
// Règle de base : ne jamais faire confiance à ce qui vient de l'utilisateur
// OWASP Top 10 => 10 familles de failles de sécurité les + courantes

// Je lance ma requête
$query->execute();

// Je traite le résultat
$nbJeux = $query->rowCount();

if ($nbJeux === 0) {
	$Alert->setAlert('Ce jeu n\'existe pas');
	$Alert->redirect('jeux.php');
}

$jeu = $query->fetch(); // Je récupère le jeu


// Récupérer le publisher, la family, la platform
// Pas de contrôle car la donnée provient du système, mais ce n'est pas une bonne habitude
$sql = 'SELECT name FROM publishers WHERE id = ' . $jeu['publisher_id'];
$query = $db->query($sql);
$query->execute();

$publisher = $query->fetch();

$sql = 'SELECT name FROM families WHERE id = ' . $jeu['family_id'];
$query = $db->query($sql);
$query->execute();

$family = $query->fetch();

$sql = 'SELECT name FROM platforms WHERE id = ' . $jeu['platform_id'];
$query = $db->query($sql);
$query->execute();

$platform = $query->fetch();

// TODO : Faire les 3 requêtes préparées pour récupérer publisher, family, et platform
// TODO : Finir l'affichage de la page "un_jeu.php"
// TODO : Bootstrap.php => Faire 2 nouvelles méthodes pour gérer les "badge" et les "alert"
// TODO : Gérer le cas où l'id ne correspond pas à un jeu (par exemple 1500)
// TODO : Créer un compte Github ou "mot de passe oublié"

// $game = $Game->getById($_GET['id']);

$html = new Bootstrap('Jeux', $jeu['name']);

// Début du DOM HTML
echo $html->startDOM();

// Menu
$html->addMenu('Présentation', 'presentation.php');
$html->addMenu('Jeux', 'jeux.php');
$html->addMenu('Inscription', 'inscription.php');
$html->setDisplayRecherche(false);

echo $html->menu();

// Main
echo $html->startMain();
?>
<div class="starter-template py-5 px-3">
	<h1 class="text-center"><?= $jeu['name']; ?></h1>
</div>
<div class="row justify-content-center">
	<div class="col col-md-8">

		<div class="card mb-2">
			<div class="card-body">
				<p>Famille : <?= $html->badge($family['name']) ;?></p>
				<p>Plateforme : <?= $html->badge($platform['name'], ['color' => WARNING]); ?></p>
				<p>Editeur : <?= $html->badge($publisher['name']); ?></p>
			</div>
		</div>

	</div>
</div>
<?php
echo $html->endMain();
echo $html->endDOM();