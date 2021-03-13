<?php
class Collection extends ORM
{
    public function __construct($id = null)
    {
        parent::__construct();
        $this->setTable('collections');

        if ($id != null) {
            $this->populate($id);
        }
    }

    public function create($gameId, $userId)
    {
        $this->addInsertFields('user_id', $userId, PDO::PARAM_INT);
        $this->addInsertFields('game_id', $gameId, PDO::PARAM_INT);
        
        $newId = $this->insert();
        $this->populate($newId);
    }

    public function alreadyCollected($gameId, $userId)
    {
        $this->addWhereFields('game_id', $gameId, '=', PDO::PARAM_INT);
        $this->addWhereFields('user_id', $userId, '=', PDO::PARAM_INT);
        return (bool) $this->get('count');
    }

    // Tableau des id de jeux possédés par un user
    public function collectionOfUser($userId)
    {
        $this->setSelectFields('id', 'game_id');
        $this->addWhereFields('user_id', $userId);

        $collection = $this->get('all');

        $collectionGameId = [];
        foreach ($collection as $c) {
            $collectionGameId[] = $c->game_id;
        }

        return $collectionGameId;
    }

    public function extractInformation($userId, $model)
    {
        // Je prends la liste des jeux
        $ids = $this->collectionOfUser($userId);

        // Je prends les jeux
        $this->Game = new Game;
        $games = $this->Game->gamesById($ids);

        // Je regarde le $model_id
        $data = [];

        foreach ($games as $game) {
            $data[] = $game->{$model  . '_id'};
        }

        return array_count_values($data);
    }
}