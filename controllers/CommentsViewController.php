<?php
class CommentsViewController extends Controller
{
    public $Comment;
    
    public function __construct()
    {
        parent::__construct();
        $this->Comment = new Comment;
    }

    public function user()
    {
        return [
            'comments' => $this->Comment->lastCommentsOfUser($this->Auth->User->id),
            'title' => 'Les commentaires de ' . $this->Auth->User->username,
            'description' => 'Tous les commentaires'
        ];
    }
}