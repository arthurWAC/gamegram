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

    public function nbLikesOfPost($postId)
    {
        $this->addWhereFields('post_id', $postId, '=', PDO::PARAM_INT);
        return $this->get('count');
    }
}