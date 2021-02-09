<?php
class Post extends ORM
{
    public $Game;
    public $User;

    public function __construct($id = null)
    {
        parent::__construct();
        $this->setTable('posts');

        if ($id != null) {
            $this->populate($id);
        }
    }

    public function create($userId, $gameId, $title, $content)
    {
        $this->addInsertFields('user_id', $userId, PDO::PARAM_INT);
        $this->addInsertFields('game_id', $gameId, PDO::PARAM_INT);
        $this->addInsertFields('title', $title, PDO::PARAM_STR);
        $this->addInsertFields('content', $content, PDO::PARAM_STR);
        $this->addInsertFields('created', date('Y-m-d H:i:s'), PDO::PARAM_STR);
        
        $newId = $this->insert();
        $this->populate($newId);
    }

    public function lastPostsWithGameAndUser()
    {
        $this->addOrder('created', 'DESC');
        $this->setSelectFields('id');
        $posts = $this->get('all');

        $postsComplete = [];
        foreach ($posts as $post) {
            $postsComplete[] = new Post($post->id);
        }

        return $postsComplete;
    }

    public function populate($id)
    {
        if (parent::populate($id)) {
            $this->Game = new Game($this->game_id);
            $this->User = new User($this->user_id);
        }
    }
}