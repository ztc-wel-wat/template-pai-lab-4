<?php

class User
{
    public $id;
    public $nazwa;

    public function __construct($id, $nazwa)
    {
        $this->id = $id;
        $this->nazwa = $nazwa;
    }
}
