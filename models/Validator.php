<?php
class Validator
{
    private $data = [];
    private $urlError;
    private $typeProcess;

    private $errors = false;

    private $Alert;
    private $Orm;

    public function __construct($data, $urlError, $typeProcess = PROCESS_FORM)
    {   
        // Type de process
        $this->typeProcess = $typeProcess;

        // Nettoyage des données
        foreach ($data as $key => $value) {
            // Je nettoie ma donnée

            // Faire d'abord un strip_tags
            $cleanValue = strip_tags($value, '<p><b><i><br><strong>');
            $cleanValue = htmlentities($cleanValue);

            // Je vais mettre ma donnée en session, si je suis dans un process de formulaire
            if ($this->typeProcess == PROCESS_FORM) {
                $_SESSION[PROCESS_FORM_SESSION . $key] = $cleanValue;
            }

            // Je stocke ma donnée nettoyée dans mon objet
            $this->data[$key] = $cleanValue;
        }

        $this->urlError = $urlError;

        // Instanciation autres objets
        $this->Alert = new Alert;
        $this->Orm = new Orm;
    }
    
    private function alert($field, $text)
    {
        if ($this->typeProcess == PROCESS_FORM) {
            $this->Alert->setAlertForm($field, $text);
        }

        $this->errors = true;
    }

    public function validateEmail($field)
    {
        if (!isset($this->data[$field])) {
            die('Erreur [Val 001] Champ '. $field .' inconnu');
        }

        if (!filter_var($this->data[$field], FILTER_VALIDATE_EMAIL)) {
            $this->alert($field, 'Erreur Email');
        }
    }

    public function validateLength($field, $length)
    {
        if (!isset($this->data[$field])) {
            die('Erreur [Val 002] Champ'. $field .' inconnu');
        }

        if (strlen($this->data[$field]) < $length) {
            $this->alert($field, 'Erreur Longueur. Attendu : ' . $length . ' caractère(s).');
        }
    }

    public function validateNumeric($field)
    {
        if (!isset($this->data[$field])) {
            die('Erreur [Val 003] Champ '. $field .' inconnu');
        }

        if (!is_numeric($this->data[$field])) {
            $this->alert($field, 'Erreur type. Valeur numérique attendue');
        }
    }

    public function validateUnique($field, $tableAndField, $typePDO = PDO::PARAM_STR)
    {
        if (!isset($this->data[$field])) {
            die('Erreur [Val 004] Champ '. $field .' inconnu');
        }

        // "Multi attribution"
        [$table, $tableField] = explode('.', $tableAndField);

        // Travail avec l'ORM
        $this->Orm->setTable($table);
        $this->Orm->addWhereFields($tableField, $this->data[$field], '=', $typePDO);

        if ($this->Orm->get('count') != 0) {
           $this->alert($field, $this->data[$field] . ' existe déjà.');
        }
    }

    public function validateExist($field, $tableAndField, $typePDO = PDO::PARAM_INT)
    {
        if (!isset($this->data[$field])) {
            die('Erreur [Val 005] Champ '. $field .' inconnu');
        }

        // "Multi attribution"
        [$table, $tableField] = explode('.', $tableAndField);

        // Travail avec l'ORM
        $this->Orm->setTable($table);
        $this->Orm->addWhereFields($tableField, $this->data[$field], '=', $typePDO);

        if ($this->Orm->get('count') == 0) {
           $this->alert($field, $this->data[$field] . ' n\'existe pas');
        }
    }

    public function validatePassword($field, $length)
    {
        // Longueur
        $this->validateLength($field, $length);

        // présence d'une lettre
        $lettres = 'abcdefghijklmnopqrstuvwxyz';
        $containLettres = false;

        // présence d'un chiffre
        $chiffres = '0123456789';
        $containChiffres = false;

        // présence d'un caractère spécial : *+-()[]{}$!.?=
        $speciaux = '*+-()[]{}$!.?=';
        $containSpeciaux = false;

        $interdits = '_%';
        $containInterdits = false;

        $pass = strtolower($this->data[$field]);
            
        $length = strlen($pass);
        for ($i = 0; $i < $length; $i++) {

            if (strpos($lettres, $pass[$i]) !== false) {
                $containLettres = true;
                continue;
            }

            if (strpos($chiffres, $pass[$i]) !== false) {
                $containChiffres = true;
                continue;
            }

            if (strpos($speciaux, $pass[$i]) !== false) {
                $containSpeciaux = true;
                continue;
            }

            if (strpos($interdits, $pass[$i]) !== false) {
                $containInterdits = true;
                continue;
            }
        }

        // return  $containLettres && 
        //         $containChiffres && 
        //         $containSpeciaux &&
        //         !$containInterdits;

        // Autre version
        if ( !(preg_match('@[a-z]@', $pass) &&
               preg_match('@[0-9]@', $pass) && 
               preg_match('@[\W]@', $pass) &&
               !preg_match('@[\_\%]{1,}@', $pass))
               ) {
                   $this->alert($field, 'Format invalide');
               }
    }

    public function crypt($field)
    {
        // Utilisation fonction md5
        $this->data[$field] = md5($this->data[$field]);
    }

    public function getData()
    {
        if ($this->errors) {
            $this->Alert->redirect($this->urlError);
        }

        return $this->data;
    }
}