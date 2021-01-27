<?php
class Publisher extends ORM
{
    public function __construct($id = null)
    {
        parent::__construct();
        $this->setTable('publishers');

        if ($id != null) {
            $this->populate($id);
        }
    }
}