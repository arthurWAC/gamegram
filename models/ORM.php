<?php
// Constantes
define('TYPE_GET_ALL', 'all');
define('TYPE_GET_FIRST', 'first');
define('TYPE_GET_COUNT', 'count');
define('TYPES_GET', [TYPE_GET_ALL, TYPE_GET_FIRST, TYPE_GET_COUNT]);

class ORM
{
    private $connexion; // Contient la connexion à ma BDD
    private $query; // Contient la requête liée à la BDD

    private $sql;

    // Doit me permettre de me connecter à ma base de données (Constructeur)
    public function __construct()
    {
        $this->connexion = new PDO(
            'mysql:host='. BDD_HOST .';dbname=' . BDD_NAME,
            BDD_USER,
            BDD_PASS
        );
    }

    // SQL ??
    public function setSQL($sql)
    {
        $this->sql = $sql;
    }

    // Doit me permettre d'executer des requêtes
    private function execute()
    {
        $this->buildSelectSQL();
        $this->query = $this->connexion->prepare($this->sql);

        // bindValue
        // Pas besoin de tester if (!empty())
        foreach ($this->whereFieldsAndValues as $wFaV) {
            $this->query->bindValue(
                ':' . $wFaV['binder'],
                $wFaV['value'],
                $wFaV['type']
            );
        }

        if (!$this->query->execute()) {
            // Erreur requête ?
            die('Erreur [ORM 002] : ' . $this->query->errorInfo()[2]);
        }
    }

    // Doit me permettre d'extraire le résultat de ces requêtes
    public function get($type)
    {
        if (!in_array($type, TYPES_GET)) {
            die('Erreur [ORM 001] : Mauvais type pour get');
        }

        $this->execute();

        switch ($type) {
            case TYPE_GET_ALL:
                return $this->query->fetchAll();
            break;

            case TYPE_GET_FIRST:
                return $this->query->fetch();
            break;

            case TYPE_GET_COUNT:
                return $this->query->rowCount();
            break;
        }
    }

    // Doit me permettre de gérer les erreurs (éventuelles) de mes requêtes

    // CONSTRUCTION DE LA REQUETE SQL

    // Pour toutes mes requêtes
    private $table;

    // Pour ma requête SELECT
    private $selectFields = [];

    // Pour mon WHERE
    private $whereFieldsAndValues = [];
    private $typeWhere = 'AND';

    public function setTable($table)
    {
        $this->table = $table;
    }
    
    public function setSelectFields()
    {   
        $this->selectFields = func_get_args();
    }

    public function setTypeWhere($type)
    {
        $this->typeWhere = $type;
    }

    // $orm->addWhereFields('id', 14);
    public function addWhereFields($field, $value, $operator = '=', 
        $type = PDO::PARAM_INT)
    {
        $this->whereFieldsAndValues[] = [
            'field' => $field,
            'value' => $value,
            'operator' => $operator,
            'type' => $type
        ];

        // execute : 
        //    - prepare() à la place de query()
        //    - faire les bindValue
    }

    private function buildSelectSQL()
    {
        // Requête de base, SELECT fields FROM table
        $sql = 'SELECT ';

        if (empty($this->selectFields)) {
            $sql .= ' * ';
        } else {
            $sql .= implode(', ', $this->selectFields);
        }

        $sql .= ' FROM ' . $this->table;

        // WHERE
        $sql .= $this->handleWhere();

        $this->sql = $sql;
    }

    private function handleWhere()
    {
        if (empty($this->whereFieldsAndValues)) {
            return '';
        }

        $wheres = [];
        $binders = [];
        foreach ($this->whereFieldsAndValues as $id => $wFaV) {

            // Vérifier que le ":truc" n'est pas déjà là, incrémenté si besoin
            $binder = $wFaV['field'];
            $nb = 2;
            while (in_array($binder, $binders)) {
                $binder = $wFaV['field'] . '_' . $nb;
                $nb++;
            }
            $binders[] = $binder;

            $wheres[] = $wFaV['field'] . ' ' . $wFaV['operator'] . ' :' . $binder;
            $this->whereFieldsAndValues[$id]['binder'] = $binder;
            // PAS équivalente à $wFaV['binder'] = $binder
        }

        // ['field' => 'id', 'value' => 14, 'operator' => '=', 'type' => INT]
        // id = :id

        return ' WHERE ' . implode(' '. $this->typeWhere .' ', $wheres);
    }

    // Méthodes d'accès rapides aux données
    public function getById($id)
    {
        $this->addWhereFields('id', $id);
        return $this->get('first');
    }

    // Je "garnis" mon objet avec des propriétés qui correspondent 
    // aux noms de mes champs
    // avec les valeurs associées à l'id
    public function populate($id)
    {
        $model = $this->getById($id);

        foreach ($model as $field => $value)
        {
            if (is_numeric($field)) {
                continue;
            }

            $this->$field = $value; // Attribution dynamique
            // PHP est permissif à ce niveau là et permet ça
        }
    }
}
