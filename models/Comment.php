<?php
class Comment extends ORM
{
    public function __construct($id = null)
    {
        parent::__construct();
        $this->setTable('comments');

        if ($id != null) {
            $this->populate($id);
        }
    }

    public function create($userId, $postId, $content)
    {
    	$this->addInsertFields('user_id', $userId, PDO::PARAM_INT);
        $this->addInsertFields('post_id', $postId, PDO::PARAM_INT);
        $this->addInsertFields('content', $content, PDO::PARAM_STR);
        $this->addInsertFields('created', date('Y-m-d H:i:s'), PDO::PARAM_STR);
        
        $newId = $this->insert();
        $this->populate($newId);
    }
}