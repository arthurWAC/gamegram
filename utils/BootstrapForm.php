<?php
define('METHOD_POST', 'post');
define('METHOD_GET', 'get');
define('METHODS', [METHOD_POST, METHOD_GET]);

define('TYPE_TEXT', 'text'); // Champ texte
define('TYPE_PASSWORD', 'password'); // Champ mot de passe
define('TYPE_NUMBER', 'number'); // Champ numérique
define('TYPE_HIDDEN', 'hidden'); // Champ caché
define('TYPES', [TYPE_TEXT, TYPE_PASSWORD, TYPE_NUMBER, TYPE_HIDDEN]);

class BootstrapForm
{
	// Propriétés
	private $action; // Notre "page" d'atterissage
	private $name; // Nom du formulaire
	private $method; // GET ou POST
	
	private $inputs = []; // Tous nos champs
	
	private $submit = []; // Informations de notre bouton submit
	
	// Constructeur
	public function __construct($name, $action, $method = METHOD_POST)
	{
		// $name => "slug" => 'Inscription nouvel utilisateur' => 'inscription_nouvel_utilisateur'
		$this->name = $this->slug($name);
		
		// On va controler la méthode
		if (!in_array($method, METHODS)) {
			die('Erreur fatale [BF 001] mauvaise configuration du formulaire ' . $name);
		}
		
		$this->method = $method;
		$this->action = $action;
	}
	
	public function addInput($name, $type, $options = [])
	{
		if (!in_array($type, TYPES)) {
			die('Erreur fatale [BF 002] mauvaise configuration du champ ' . $name);
		}
		
		// $form->addInput('username', TYPE_TEXT);
		// $form->addInput('password', TYPE_PASSWORD);
		$this->inputs[] = [
			'name' => $name,
			'type' => $type,
			'options' => $options
		];
	}
	
	// Retourne du HTML
	private function input($name, $type, $options = [])
	{
		// Options : label, 
		$input = '<div class="mb-3">';
		
		$id = $this->slug($this->name . ' ' . $name); // Je concatène le nom du formulaire et le nom du champ
		
		if ($type != TYPE_HIDDEN) {
			$label = $options['label'] ?? $name;
			$input .= '<label for="'. $id .'" class="form-label">'. $label .'</label>';
		}
		
		// TODO : rajouter le type email (pour le champ username dans inscription.php)
		// TODO : autres options à gérer : placeholder, value, step, min, max
		// TODO : manipuler la grille pour avoir un rendu visuel + sympa, ne pas avoir des input qui prennent 100% de large
		// TODO : mettre form-label et form-control dans des constantes (à la manière de BTN)
		
		$input .= '<input type="'. $type .'" class="form-control" id="'. $id .'" name="'. $this->slug($name) .'"/>';
	
		$input .= '</div>';
		
		return $input;
	}
	
	public function setSubmit($name, $options = [])
	{
		// $form->setSubmit('Je m\'inscris', ['color' => SUCCESS]);
		$this->submit = [
			'name' => $name,
			'options' => $options
		];
	}
	
	// Retourne du HTML
	private function submit()
	{
		$color = $this->submit['options']['color'] ?? PRIMARY;
		
		return '<button type="submit" class="'. BTN . ' ' . BTN . '-' . $color .'">'. $this->submit['name'] .'</button>';
	}
	
	// Construction HTML complète de mon formulaire
	public function form()
	{
		// Début du formulaire
		$form = '<form method="'. $this->method .'" action="'. $this->action .'">';
		
		// Pour savoir, sur la page d'atterissage, quel est le formulaire soumis
		$form .= $this->input($this->name, TYPE_HIDDEN);
		
		// Inputs
		foreach ($this->inputs as $input) {
			$form .= $this->input($input['name'], $input['type'], $input['options']);
		}
		
		// Submit
		$form .= $this->submit();
	
		// Fin du formulaire
		$form .= '</form>';
		
		return $form;
	}
	
	// ????
	public function slug($string)
	{
		return strtolower(trim(preg_replace('/[^A-Za-z0-9_]+/', '_', $string)));
	}
}