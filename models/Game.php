<?php
class Game extends ORM
{
    public $Platform;
    public $Publisher;
    public $Family;

    public function __construct($id = null)
    {
        parent::__construct();
        $this->setTable('games');

        $this->Platform = new Platform;
        $this->Publisher = new Publisher;
        $this->Family = new Family;

        if ($id != null) {
            $this->populate($id);
        }
    }
    
    // Méhodes spécifiques à ce modèle
    public function listOfPublicGames()
    {
        $this->setSelectFields('id', 'name', 'year', 'note');
        $this->addWhereFields('public', 1);
        $this->addOrder('name');

        return $this->get('all');
    }

    public function publicGamesById()
    {
        $publicGames = $this->listOfPublicGames();
        $gamesById = [];

        foreach ($publicGames as $game) {
            $gamesById[$game->id] = $game->name;
        }

        return $gamesById;
    }

    public function search($name, $options = [])
    {
        // Début de la requête
        $this->setSelectFields('id', 'name', 'year', 'note');
        $this->addWhereFields('public', 1);
        $this->addOrder('name');

        // Traitement de mes choix de recherche
        $this->addWhereFields('name', '%' . $name . '%', 'LIKE', PDO::PARAM_STR);

        // $this->addWhereFieldsFromGET($options, 'platform_id');
        // $this->addWhereFieldsFromGET($options, 'family_id');
        // $this->addWhereFieldsFromGET($options, 'publisher_id');

        if (isset($options['platform_id']) && $options['platform_id'] != 0) {
            $this->addWhereFields('platform_id', $options['platform_id']);
        }

        if (isset($options['family_id']) && $options['family_id'] != 0) {
            $this->addWhereFields('family_id', $options['family_id']);
        }

        if (isset($options['publisher_id']) && $options['publisher_id'] != 0) {
            $this->addWhereFields('publisher_id', $options['publisher_id']);
        }

        if (isset($options['note'])) {
            $this->addWhereFields('note', $options['note'], '>=', PDO::PARAM_STR);
        }

        return $this->get('all');
    }

    public function gamesByFamilies(array $families)
    {
        $this->setSelectFields('id', 'name', 'year', 'note');
        $this->setTypeWhere('OR');

        foreach ($families as $family_id) {
            $this->addWhereFields('family_id', $family_id);
        }

        return $this->get('all');
    }

    public function multiGames($model, $ids)
    {
        $this->setSelectFields('id', 'name', 'year', 'note');
        $this->setTypeWhere('OR');

        foreach ($ids as $id) {
            $this->addWhereFields($model . '_id', $id);
        }

        return $this->get('all');
    }

    public function gamesById($ids)
    {
        $this->setTypeWhere('OR');

        foreach ($ids as $id) {
            $this->addWhereFields('id', $id);
        }

        return $this->get('all');
    }

    // Méthode du coeur du système
    public function populate($id)
    {
        if (parent::populate($id)) {
            // Si j'arrive à "garnir" Game, je peux alors "garnir"
            // les modèles associés
            $this->Platform = new Platform($this->platform_id);
            $this->Publisher = new Publisher($this->publisher_id);
            $this->Family = new Family($this->family_id);
        }
    }
}