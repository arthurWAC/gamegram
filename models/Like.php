<?php
class Like extends ORM
{
    public function __construct($id = null)
    {
        parent::__construct();
        $this->setTable('likes');

        if ($id != null) {
            $this->populate($id);
        }
    }

    public function create($postId, $userId)
    {
        $this->addInsertFields('user_id', $userId, PDO::PARAM_INT);
        $this->addInsertFields('post_id', $postId, PDO::PARAM_INT);
        
        $newId = $this->insert();
        $this->populate($newId);
    }

    public function nbLikesOfPost($postId)
    {
        $this->addWhereFields('post_id', $postId, '=', PDO::PARAM_INT);
        return $this->get('count');
    }

    public function alreadyLike($postId, $userId)
    {
        $this->addWhereFields('post_id', $postId, '=', PDO::PARAM_INT);
        $this->addWhereFields('user_id', $userId, '=', PDO::PARAM_INT);
        return (bool) $this->get('count');
    }

    public function unlike($postId, $userId)
    {
        $this->addWhereFields('post_id', $postId, '=', PDO::PARAM_INT);
        $this->addWhereFields('user_id', $userId, '=', PDO::PARAM_INT);
        $this->delete();
    }
}