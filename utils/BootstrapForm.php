<?php
class BootstrapForm
{
	// Propriétés
	private $action; // Notre "page" d'atterissage
	private $name; // Nom du formulaire
	private $method; // GET ou POST
	
	private $inputs = []; // Tous nos champs
	
	private $submit = []; // Informations de notre bouton submit

	private $htmlAttributs; // Pour gérer efficacement les attributs HTML des mes inputs
	
	// Constructeur
	public function __construct($name, $model, $method = METHOD_POST)
	{
		// $name => "slug" => 'Inscription nouvel utilisateur' => 'inscription_nouvel_utilisateur'
		$this->name = $this->camelCase($name);
		
		// On va controler la méthode
		if (!in_array($method, METHODS)) {
			die('Erreur fatale [BF 001] mauvaise configuration du formulaire ' . $name);
		}
		
		$this->method = $method;

		// POST => Process
		if ($this->method == METHOD_POST) {
			$this->action = Router::urlProcess($model . 's', $this->name);
		}

		// GET => View
		if ($this->method == METHOD_GET) {
			$this->action = Router::urlView();
			$this->addInput('dir', TYPE_HIDDEN, ['value' => $model . 's']);
			$this->addInput('page', TYPE_HIDDEN, ['value' => $this->name]);
		}
	}
	
	public function addInput($name, $type, $options = [])
	{
		if (!in_array($type, TYPES)) {
			die('Erreur fatale [BF 002] mauvaise configuration du champ ' . $name);
		}
		
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
			$input .= '<label for="'. $id .'" class="'. FORM_LABEL .'">'. $label .'</label>';
		}

		// Mes attributs HTML supplémentaires
		$this->htmlAttributs = '';

		// Je vais gérer les options step, min, max pour les types number
		if ($type === TYPE_NUMBER) {
			$this->handleHtmlAttributs($options, 'step');
			$this->handleHtmlAttributs($options, 'min');
			$this->handleHtmlAttributs($options, 'max');
		}

		// placeholder, en dehors des champs hidden
		if ($type !== TYPE_HIDDEN) {
			$this->handleHtmlAttributs($options, 'placeholder');
		}
		
		// Construction de mon <input ... /> ou <select ...> ou <texarea ...>
		switch ($type) {

			case TYPE_SELECT:

				$class = FORM_SELECT;

				if (isset($options['class'])) {
					$class .= ' ' . $options['class'];
				}

				$input .= '<select class="'. $class .'" id="'. $id .'" name="'. $this->slug($name) .'" '. $this->htmlAttributs .'>';

				if (!isset($options['data'])) {
					die('Erreur fatale [BF 003] data manquante pour le select ' . $name);
				}

				if (isset($options['empty'])) {
    				$options['data'] = Libarray::pop($options['data'], $options['empty']);
				}

				foreach ($options['data'] as $value => $name) {

					$selected = '';
					if (isset($options['value']) && $options['value'] == $value) {
						$selected = 'selected';
					}

					$input .= '<option value="'. $value .'" '. $selected .'>' . $name . '</option>';
				}

				$input .= '</select>';
			break;

			case TYPE_TEXTAREA:

				$class = FORM_CONTROL;

				if (isset($options['class'])) {
					$class .= ' ' . $options['class'];
				}

				$rows = $options['rows'] ?? 5;

				$input .= '<textarea class="'. $class .'" rows="'. $rows .'" id="'. $id .'" name="'. $this->slug($name) .'" '. $this->htmlAttributs .'>';

				if (isset($options['value'])) {
					$input .= $value;
				}

				$input .= '</textarea>';
			break;

			case TYPE_RADIO:

				if (!isset($options['data'])) {
					die('Erreur fatale [BF 004] data manquante pour le radio ' . $name);
				}

				foreach ($options['data'] as $value => $label) {
					$input .= '<div class="'. FORM_CHECK .'">';

					// Quelque chose d'unique sur la page courante
					$id = $this->slug($this->name . ' ' . $name . ' ' . $label . ' ' . $value);
					
					$checked = '';
					if (isset($options['value']) && $options['value'] == $value) {
						$checked = ' checked';
					}
					
					$input .= '<input class="'. FORM_CHECK_INPUT .'" type="radio" name="'. $name .'" 
													value="'. $value .'" id="'. $id .'" '. $checked .'/>';
					$input .= '<label class="'. FORM_CHECK_LABEL .'" for="'. $id .'">' .
								$label .
								'</label>';

					$input .= '</div>';
				}
			
  


			break;

			default:
				// et value, pour tout le monde, sauf password
				if ($type !== TYPE_PASSWORD) {
					$this->handleValue($name, $options);
				}

				$input .= '<input type="'. $type .'" class="'. FORM_CONTROL .'" id="'. $id .'" name="'. $this->slug($name) .'" '. $this->htmlAttributs .'/>';
			break;
		}

		$input .= $this->handleHelpAlert($name);

		$input .= '</div>';
		
		return $input;
	}

	private function handleHelpAlert($name)
	{
		if (!isset($_SESSION[PROCESS_FORM_SESSION_HELP . $name])) {
			return '';
		}

		$help = $_SESSION[PROCESS_FORM_SESSION_HELP . $name];
		unset($_SESSION[PROCESS_FORM_SESSION_HELP . $name]);

		return '<div class="form-text badge bg-danger">' .
				$help .
				'</div>';
	}

	private function handleValue($name, $options)
	{
		if (isset($options['value'])) {
			// On privilégie la value passée dans le formulaire VS une value présente en session
			$this->handleHtmlAttributs($options, 'value');
		} elseif (isset($_SESSION[PROCESS_FORM_SESSION . $name])) {
			$this->htmlAttributs .= 'value="'. $_SESSION[PROCESS_FORM_SESSION . $name] .'" ';
			unset($_SESSION[PROCESS_FORM_SESSION . $name]);
		}
	}

	private function handleHtmlAttributs($options, $field)
	{
		if (isset($options[$field])) {
			$this->htmlAttributs .= $field . '="'. $options[$field] .'" ';
		}
	}
	
	public function setSubmit($name, $options = [])
	{
		$this->submit = [
			'name' => $name,
			'options' => $options
		];
	}
	
	// Retourne du HTML
	private function submit()
	{
		$color = $this->submit['options']['color'] ?? PRIMARY;

		// Class par défaut
		$class = BTN . ' ' . BTN . '-' . $color . ' ';
		
		// Classes supplémentaires
		$class .= $this->submit['options']['class'] ?? '';
		
		return '<button type="submit" class="'. $class .'">'. $this->submit['name'] .'</button>';
	}
	
	// Construction HTML complète de mon formulaire
	public function form()
	{
		// Début du formulaire
		$form = '<form method="'. $this->method .'" action="'. $this->action .'">';
		
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
	
	// Inscription Nouvel Utilisateur => inscription_nouvel_utilisateur
	public function slug($string)
	{
		return strtolower(trim(preg_replace('/[^A-Za-z0-9_]+/', '_', $string)));
	}

	// Inscription Nouvel Utilisateur => inscriptionNouvelUtilisateur
	public function camelCase($string)
	{
		$string = $this->slug($string); // inscription_nouvel_utilisateur
		$string = str_replace('_', ' ', $string); // inscription nouvel utilisateur
		$string = ucwords($string); // Inscription Nouvel Utilisateur
		return lcfirst(str_replace(' ', '', $string)); // InscriptionNouvelUtilisateur // inscriptionNouvelUtilisateur
	}
}