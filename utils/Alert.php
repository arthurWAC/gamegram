<?php
define('SESSION_ALERT', 'session_alert');

class Alert
{
    // Pas de constructeur

    // Méthode qui set mon alerte dans ma session
    public function setAlert($text, $options = [])
    {
		$_SESSION[SESSION_ALERT] = [
			'text' => $text,
			'options' => $options
		];
    }

    // Méthode qui redirige
    public function redirect($link)
    {
        header('Location: ' . $link);
        exit;
    }

    // Méthode qui renvoie l'HTML de l'alerte
    public function getAlertHTML()
    {
        if (!isset($_SESSION[SESSION_ALERT])) {
			return '';
		}

        // J'utilise mon autre objet BootstrapAlert
        $alert = new BootstrapAlert(
            $_SESSION[SESSION_ALERT]['text'],
            $_SESSION[SESSION_ALERT]['options']
        );

        $this->emptySession();

        return $alert->alert(); // J'utilise la méthode "alert" de BootstrapAlert
    }

    // Méthode qui vide la session
    private function emptySession()
    {
        unset($_SESSION[SESSION_ALERT]);
    }
}