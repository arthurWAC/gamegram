<?php
class User extends ORM
{
    public function __construct($id = null)
    {
        parent::__construct();
        $this->setTable('users');

        if ($id != null) {
            $this->populate($id);
        }
    }

    public function create($username, $password, $pseudo, $nbJeux)
    {
        $this->addInsertFields('username', $username, PDO::PARAM_STR);
        $this->addInsertFields('password', $password, PDO::PARAM_STR);
        $this->addInsertFields('pseudo', $pseudo, PDO::PARAM_STR);
        $this->addInsertFields('nb_games', $nbJeux, PDO::PARAM_INT);
        $this->addInsertFields('created', date('Y-m-d H:i:s'), PDO::PARAM_STR);
        
        $newId = $this->insert();
        $this->populate($newId);
    }

    public function updateInformations($id, $data)
    {
        $this->addWhereFields('id', $id, '=', PDO::PARAM_INT);

        $this->addUpdateFields('username', $data['username'], PDO::PARAM_STR);
        $this->addUpdateFields('pseudo', $data['pseudo'], PDO::PARAM_STR);
        $this->addUpdateFields('nb_games', $data['nb_jeux'], PDO::PARAM_INT);

        if (isset($data['password'])) {
            $this->addUpdateFields('password', $data['password'], PDO::PARAM_STR);
        }

        $this->update();
    }

    public function login($username, $cryptedPassword)
    {
        $this->addWhereFields('username', $username, '=', PDO::PARAM_STR);
        $this->addWhereFields('password', $cryptedPassword, '=', PDO::PARAM_STR);
        $this->setSelectFields('id');

        $user = $this->get('first');

        if (!empty($user)) {
            $this->populate($user['id']);
            return true;
        }
        
        return false;
    }

    public function loadLastPosts()
    {
        $post = new Post;
        $this->Posts = $post->lastPostsOfUser($this->id);
    }

    public function loadLastComments()
    {
        $comment = new Comment;
        $this->Comments = $comment->lastCommentsOfUser($this->id);
    }

    public function loadLastPostsAndComments()
    {
        $this->loadLastPosts();
        $this->loadLastComments();

        $dataByCreated = [];

        foreach ($this->Posts as $post) {
            $dataByCreated[] = [
                'created' => $post->created,
                'data' => $post
            ];
        }

        foreach ($this->Comments as $comment) {
            $dataByCreated[] = [
                'created' => $comment->created,
                'data' => $comment
            ];
        }

        usort($dataByCreated, function ($item1, $item2) {
            return $item2['created'] <=> $item1['created'];
        });

        $this->LastPostsAndComments = $dataByCreated;
    }
}