<?php
class Game extends ORM
{
    public $Platform;
    public $Publisher;
    public $Family;

    public function __construct($id = null)
    {
        parent::__construct();
        $this->setTable('games');

        if ($id != null) {
            $this->populate($id);
        }
    }

    public function populate($id)
    {
        parent::populate($id);
        $this->Platform = new Platform($this->platform_id);
        $this->Publisher = new Publisher($this->publisher_id);
        $this->Family = new Family($this->family_id);
    }
}