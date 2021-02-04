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

    public function create($name)
    {
        $this->addInsertFields('name', $name, PDO::PARAM_STR);
        $newId = $this->insert();
        $this->populate($newId);
    }
}