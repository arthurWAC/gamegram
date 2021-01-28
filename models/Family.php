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
        // Pas $this->get('...');
        // TODO : faire la fonction insert
        // TODO : retourne le nouvel id créé
        $newId = $this->insert(); // Regarder du côte de "pdo.exec"
        $this->populate($newId);
    }
}