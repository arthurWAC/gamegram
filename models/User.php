<?php
class User extends ORM
{

    public function create($username, $password, $pseudo)
    {
        $this->addInsertFields('username', $username, PDO::PARAM_STR);
        $this->addInsertFields('password', $password, PDO::PARAM_STR);
        $this->addInsertFields('pseudo', $peudo, PDO::PARAM_STR);
        $this->launch(); // Regarder du côte de "exec"
    }
}