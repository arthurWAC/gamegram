<?php
class Family extends ORM
{
    public function __construct($id = null)
    {
        parent::__construct();
        $this->setTable('families');

        if ($id != null) {
            $this->populate($id);
        }
    }
}