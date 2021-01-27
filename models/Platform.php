<?php
class Platform extends ORM
{
    public function __construct($id = null)
    {
        parent::__construct();
        $this->setTable('platforms');

        if ($id != null) {
            $this->populate($id);
        }
    }
}