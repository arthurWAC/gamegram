<?php
class BootstrapAlert
{
    private $text;
    private $options;

    public function __construct($text, $options = [])
    {
        $this->text = $text;
        $this->options = $options;
    }

    public function alert()
    {
        // Gestion de la couleur
		$color = $this->options['color'] ?? DANGER; 
		
		// Class par défaut
		$class = ALERT . ' ' . ALERT . '-' . $color . ' ';
		
		// Classes supplémentaires
		$class .= $this->options['class'] ?? '';

        return '<div class="mt-3 ' . $class . '">' .
                $this->text . 
                '</div>';
    }
}