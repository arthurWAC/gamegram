<?php
include('loader.php'); // Ma ligne de base sur chacun de mes fichiers

if (isset($_POST['inscription'])) {
    // Je vais traiter mon formulaire d'inscription

    // Inscrire mon utilisateur ?

        // [0] Contrôles de base :
            // Nettoyage des données, avec la fonction htmlentities
            $validator = new Validator($_POST, 'inscription.php');

            // username est bien une adresse mail, avec la fonction filter_var
            $validator->validateEmail('username');

            $validator->validateLength('password', 8);

            // pseudo fait bien 4 caractères minimum, strlen
            $validator->validateLength('pseudo', 4);

            // nb_jeux est bien un nombre, is_numeric
            $validator->validateNumeric('nb_jeux');

        // [1] Contrôles d'unicité (via les modèles et l'ORM)
            // username est unique
            $validator->validateUnique('username', 'users.username');

            // pseudo est unique
            $validator->validateUnique('pseudo', 'users.pseudo');

        // [2] Contrôle Qualité du mot de passe
            // mot de passe fait bien 8 caractères minimum, strlen
            $validator->validatePassword('password', 8);

        // Tous mes contrôles sont OK, je peux ajouter mon nouvel utilisateur
            // Crypte le mot de passe, via md5
            $validator->crypt('password');
            
            // Inserer le tout dans la table grâce à mon ORM
            $data = $validator->getData();

            $user = new User();
            $user->create(
                $data['username'],
                $data['password'],
                $data['pseudo'],
                $data['nb_jeux']
            );

            $Alert->setAlert('Compte créé avec succès !', ['color' => SUCCESS]);
            $Alert->redirect('connexion.php');
}



if (isset($_POST['connexion'])) {
    // Je veux savoir si mon couple login + mot de passe correspond bien à User enregistré ?

    // [0] Je nettoie les données en provenance de l'utilisateur
        $validator = new Validator($_POST, 'connexion.php');
        $validator->validateEmail('username');
        $validator->validatePassword('password', 8);
        $validator->crypt('password');
        $data = $validator->getData();

    // [1] Je cherche un user qui correspond au couple login / mot de passe
    $user = new User;
    if (!$user->login($data['username'], $data['password'])) {
        $Alert->setAlert('Mauvaise combinaison login / mot de passe', ['color' => DANGER]);
        $Alert->redirect('connexion.php');
    }

    // $user a été populate par la méthode login

    // Je vais mettre en SESSION le fait que je suis connecté
    // Je vais le faire via un objet dédié : Auth(entification)
    $Auth->setUser($user->id);

    $Alert->setAlert('Welcome back ' . $Auth->User->pseudo . ' !', ['color' => SUCCESS]);
    $Alert->redirect('feed.php');
}

// Déconnexion
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    $Auth->logout();

    $Alert->setAlert('Déconnexion OK', ['color' => SUCCESS]);
    $Alert->redirect('index.php');
}

// Nouveau Post
if (isset($_POST['nouveau_post'])) {

    $validator = new Validator($_POST, 'new_post.php');

    // Le title n'est pas vide
    $validator->validateLength('title', 10);

    // Le contenu n'est pas vide
    $validator->validateLength('content', 30);

    // Un jeu a bien été choisi
    $validator->validateNumeric('game_id');

    $data = $validator->getData();

    $post = new Post();
    $post->create(
        $Auth->User->id, // Accès direct ici au User.id
        $data['game_id'],
        $data['title'],
        $data['content']
    );

    $Alert->setAlert('Post créé avec succès !', ['color' => SUCCESS]);
    $Alert->redirect('feed.php');
}

// Nouveau commentaire
if (isset($_POST['nouveau_commentaire'])) {

    $validator = new Validator($_POST, 'post.php?id=' . $_POST['post_id']);

    // Un post a bien été choisi
    $validator->validateNumeric('post_id');

    // Le post choisi existe
    $validator->validateExist('post_id', 'posts.id');

    // Le contenu n'est pas vide
    $validator->validateLength('content', 5);

    $data = $validator->getData();

    $comment = new Comment();
    $comment->create(
        $Auth->User->id, // Accès direct ici au User.id
        $data['post_id'],
        $data['content']
    );

    $Alert->setAlert('Commentaire créé avec succès !', ['color' => SUCCESS]);
    $Alert->redirect('post.php?id=' . $data['post_id']);
}