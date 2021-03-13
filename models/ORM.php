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

    // CONSTRUCTION DE LA REQUETE SQL
    private $sql;

    // Pour toutes mes requêtes
    private $table;

    // Pour ma requête SELECT
    private $selectFields;

    // Pour mon WHERE
    private $whereFieldsAndValues;
    private $typeWhere;

    // Pour le ORDER
    private $orderFieldsAndDirection;

    // Pour le LIMIT
    private $limitCount;
    private $limitOffset;

    // Pour le INSERT
    private $insertFieldsAndValues;

    // Pour le UPDATE
    private $updateFieldsAndValues;

    // Permet de savoir si une entrée donnée existe
    private $existInBDD = false; 

    // Doit me permettre de me connecter à ma base de données (Constructeur)
    public function __construct()
    {
        $this->connexion = new PDO(
            'mysql:host='. BDD_HOST .';dbname=' . BDD_NAME,
            BDD_USER,
            BDD_PASS
        );

        $this->resetPropertiesSQL(); // ou setDefaultValuesSQL
    }

    // On remet "à zéro" les propriétés qui permettent de créer la requête SQL
    private function resetPropertiesSQL()
    {
        // Pour ma requête SELECT
        $this->selectFields = [];

        // Pour mon WHERE
        $this->whereFieldsAndValues = [];
        $this->typeWhere = 'AND';

        // Pour mon ORDER
        $this->orderFieldsAndDirection = [];

        // Pour mon LIMIT
        $this->limitCount = null;
        $this->limitOffset = null;

        // Pour ma requête INSERT
        $this->insertFieldsAndValues = [];

        // Pour ma requête UPDATE
        $this->updateFieldsAndValues = [];
    }

    // Doit me permettre d'executer des requêtes
    private function execute()
    {
        // On construit la requête
        $this->buildSelectSQL();

        $this->query = $this->connexion->prepare($this->sql);

        // bindValue
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
        
        // On remet "à zéro" les propriétés qui permettent de créer la requête SQL
        $this->resetPropertiesSQL(); 
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
                return $this->query->fetchAll(PDO::FETCH_CLASS);
            break;

            case TYPE_GET_FIRST:
                return $this->query->fetch();
            break;

            case TYPE_GET_COUNT:
                return $this->query->rowCount();
            break;
        }
    }

    public function insert()
    {
        // On construit la requête
        $this->buildInsertSQL();

        $this->query = $this->connexion->prepare($this->sql);

        // bindValue
        // Pas besoin de tester if (!empty())
        foreach ($this->insertFieldsAndValues as $iFaV) {
            $this->query->bindValue(
                $iFaV['bind'],
                $iFaV['value'],
                $iFaV['type']
            );
        }

        if (!$this->query->execute()) {
            // Erreur requête ?
            die('Erreur [ORM 003] : ' . $this->query->errorInfo()[2]);
        }
        // On remet "à zéro" les propriétés qui permettent de créer la requête SQL
        $this->resetPropertiesSQL();
        
       return $this->getLastId();
    }

    public function update()
    {
        // On construit la requête
        $this->buildUpdateSQL();

        $this->query = $this->connexion->prepare($this->sql);

        // bindValue des SET
        foreach ($this->updateFieldsAndValues as $uFaV) {
            $this->query->bindValue(
                $uFaV['bind'],
                $uFaV['value'],
                $uFaV['type']
            );
        }

        // bindValue des WHERE
        foreach ($this->whereFieldsAndValues as $wFaV) {
            $this->query->bindValue(
                ':' . $wFaV['binder'],
                $wFaV['value'],
                $wFaV['type']
            );
        }

        if (!$this->query->execute()) {
            // Erreur requête ?
            die('Erreur [ORM 009] : ' . $this->query->errorInfo()[2]);
        }
        
        // On remet "à zéro" les propriétés qui permettent de créer la requête SQL
        $this->resetPropertiesSQL(); 
    }

    public function delete()
    {
        // On construit la requête
        $this->buildDeleteSQL();

        $this->query = $this->connexion->prepare($this->sql);

        // bindValue
        foreach ($this->whereFieldsAndValues as $wFaV) {
            $this->query->bindValue(
                ':' . $wFaV['binder'],
                $wFaV['value'],
                $wFaV['type']
            );
        }

        if (!$this->query->execute()) {
            // Erreur requête ?
            die('Erreur [ORM 004] : ' . $this->query->errorInfo()[2]);
        }
        
        // On remet "à zéro" les propriétés qui permettent de créer la requête SQL
        $this->resetPropertiesSQL(); 
    }

    // On va chercher le dernier ID ajouté dans la table
    public function getLastId()
    {
        $this->addOrder('id', 'DESC');
        $this->setSelectFields('id');
        return $this->get('first')['id'];
    }

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

    public function addWhereFields($field, $value, $operator = '=', $type = PDO::PARAM_INT)
    {
        $this->whereFieldsAndValues[] = [
            'field' => $field,
            'value' => $value,
            'operator' => $operator,
            'type' => $type
        ];
    }

    public function addOrder($field, $direction = 'ASC')
    {
        $this->orderFieldsAndDirection[] = [
            'field' => $field,
            'direction' => $direction
        ];
    }

    public function setLimit($count, $offset = null)
    {
        $this->limitCount = $count;

        if ($offset !== null) {
            $this->limitOffset = $offset;
        }
    }

    public function addInsertFields($field, $value, $type = PDO::PARAM_STR)
    {
        $this->insertFieldsAndValues[] = [
            'field' => '`' . $field . '`', // Je stocke les valeurs comme
            'bind' => ':' . $field, // j'en aurais besoin dans mon SQL
            'value' => $value,
            'type' => $type
        ];
    }

    public function addUpdateFields($field, $value, $type = PDO::PARAM_STR)
    {
        $this->updateFieldsAndValues[] = [
            'field' => '`' . $field . '`', // Je stocke les valeurs comme
            'bind' => ':' . $field, // j'en aurais besoin dans mon SQL
            'value' => $value,
            'type' => $type
        ];
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

        // ORDER
        $sql .= $this->handleOrder();

        // LIMIT
        $sql .= $this->handleLimit();

        $this->sql = $sql;
    }

    private function buildInsertSQL()
    {
        // Requête de base, INSERT INTO `families` (`name`) VALUES ('RPG');
        $sql = 'INSERT INTO ' . $this->table . ' ';

        // Champs
        $sql .= '(';
        $sql .= implode(',', array_column($this->insertFieldsAndValues, 'field'));
        $sql .= ')';

        // Valeurs
        $sql .= ' VALUES ';
        $sql .= '(';
        $sql .= implode(',', array_column($this->insertFieldsAndValues, 'bind'));
        $sql .= ')';

        $this->sql = $sql;
    }

    private function buildUpdateSQL()
    {
        $sql = 'UPDATE ' . $this->table . ' ';

        $sql .= $this->handleSet();

        // Sécurité
        if (empty($this->whereFieldsAndValues)) {
            die('Erreur [ORM 006] : Il faut obligatoirement renseigner des conditions pour un UPDATE');
        }

        $sql .= $this->handleWhere();

        $this->sql = $sql;
    }

    private function buildDeleteSQL()
    {
        $sql = 'DELETE FROM ' . $this->table . ' ';

        // Sécurité
        if (empty($this->whereFieldsAndValues)) {
            die('Erreur [ORM 005] : Il faut obligatoirement renseigner des conditions pour un DELETE');
        }

        $sql .= $this->handleWhere();

        $this->sql = $sql;
    }

    private function handleSet()
    {
        // Sécurité
        if (empty($this->updateFieldsAndValues)) {
            die('Erreur [ORM 006] : Il faut obligatoirement renseigner des valeurs à changer pour un UPDATE');
        }

        $updates = [];
        foreach ($this->updateFieldsAndValues as $uFaV) {
            $updates[] = $uFaV['field'] . ' = ' . $uFaV['bind'];
        }

        return 'SET ' . implode(' , ', $updates);
    }

    private function handleOrder()
    {
        if (empty($this->orderFieldsAndDirection)) {
            return '';
        }

        $orders = [];
        foreach ($this->orderFieldsAndDirection as $oFaD) {
            $orders[] = $oFaD['field'] . ' ' . $oFaD['direction'];
        }

        return ' ORDER BY ' . implode(', ', $orders);
    }

    private function handleLimit()
    {
        if (empty($this->limitCount)) {
            return '';
        }

        $limit = ' LIMIT ';

        if ($this->limitOffset !== null) {
            $limit .= $this->limitOffset . ',';
        }

        $limit .= $this->limitCount;

        return $limit;
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
        // Vérifier ce qu'il se passe ici ?
        $this->addWhereFields('id', $id);
        return $this->get('first');
    }

    // On vérifie que l'élément correspondant à $id existe
    public function existInBDD($id)
    {
        $this->addWhereFields('id', $id);
        $this->setSelectFields('id');

        return $this->existInBDD = (bool) $this->get('count');

        // Equivalent à
        $this->existInBDD = (bool) $this->get('count');
        return $this->existInBDD;
    }

    // Je "garnis" mon objet avec des propriétés qui correspondent 
    // aux noms de mes champs
    // avec les valeurs associées à l'id
    public function populate($id)
    {
        // Vérifie l'existence
        if (!$this->existInBDD($id)) {
            return false;
        }

        // On va chercher les données
        $model = $this->getById($id);

        foreach ($model as $field => $value) {
            if (is_numeric($field)) {
                continue;
            }

            $this->$field = $value; // Attribution dynamique
            // PHP est permissif à ce niveau là et permet ça
        }

        return true;
    }

    public function exist()
    {
        return $this->existInBDD;
    }

    public function getList(string $fieldId = 'id', string $fieldName = 'name'): array
    {
        $this->setSelectFields($fieldId, $fieldName);
        $this->addOrder($fieldName);

        $values = $this->get('all');
        $valuesById = [];

        foreach ($values as $value) {
            $valuesById[$value->$fieldId] = $value->$fieldName;
        }

        return $valuesById;
    }
}
