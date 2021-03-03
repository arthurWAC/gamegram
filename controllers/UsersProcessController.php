<?php
class UsersProcessController extends Controller
{
    public $User;
    
    public function __construct()
    {
        parent::__construct();
        $this->User = new User;
    }

    public function inscriptionNouvelUtilisateur()
    {
        $validator = new Validator(
            $_POST,
            ['dir' => 'users', 'page' => 'inscription']
        );

        $validator->validateEmail('username');
        $validator->validateLength('password', 8);
        $validator->validateLength('pseudo', 4);
        $validator->validateNumeric('nb_jeux');

        $validator->validateUnique('username', 'users.username');
        $validator->validateUnique('pseudo', 'users.pseudo');

        $validator->validatePassword('password', 8);
        $validator->crypt('password');
        
        $data = $validator->getData();

        $this->User->create(
            $data['username'],
            $data['password'],
            $data['pseudo'],
            $data['nb_jeux']
        );

        $this->Alert->setAlert('Compte créé avec succès !', ['color' => SUCCESS]);
        $this->Alert->redirect(['dir' => 'users', 'page' => 'connexion']);
    }

    public function connexion()
    {
        $validator = new Validator($_POST, ['dir' => 'users', 'page' => 'connexion']);
        $validator->validateEmail('username');
        $validator->validatePassword('password', 8);
        $validator->crypt('password');
        $data = $validator->getData();

        if (!$this->User->login($data['username'], $data['password'])) {
            $this->Alert->setAlert('Mauvaise combinaison login / mot de passe', ['color' => DANGER]);
            $this->Alert->redirect(['dir' => 'users', 'page' => 'connexion']);
        }

        $this->Auth->setUser($this->User->id);

        $this->Alert->setAlert('Welcome back ' . $this->Auth->User->pseudo . ' !', ['color' => SUCCESS]);
        $this->Alert->redirect(['dir' => 'posts', 'page' => 'feed']);
    }

    public function logout()
    {
        $this->Auth->logout();

        $this->Alert->setAlert('Déconnexion OK', ['color' => SUCCESS]);
        $this->Alert->redirect(['dir' => '', 'page' => '']);
    }

    public function modification()
    {
        // Mot de passe ?
        $updatePassword = true;
        if ($_POST['password'] == '') {
            unset($_POST['password']);
            $updatePassword = false;
        }

        $validator = new Validator($_POST, ['dir' => 'users', 'page' => 'profil']);

        $validator->validateEmail('username');
        $validator->validateLength('pseudo', 4);
        $validator->validateNumeric('nb_jeux');

        if ($updatePassword) {
            $validator->validatePassword('password', 8);
            $validator->crypt('password');
        }

        $data = $validator->getData();

        // Contrôles unicité
        if ($data['username'] !== $this->Auth->User->username) {
            $validator->validateUnique('username', 'users.username');
        }

        if ($data['pseudo'] !== $this->Auth->User->pseudo) {
            $validator->validateUnique('pseudo', 'users.pseudo');
        }

        // Mise à jour
        $this->User->updateInformations($this->Auth->User->id, $data);

        $this->Alert->setAlert('Informations mises à jour !', ['color' => SUCCESS]);
        $this->Alert->redirect(['dir' => 'users', 'page' => 'profil']);
    }
}