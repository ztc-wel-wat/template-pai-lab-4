<?php
class User
{
    public $id;
    public $nazwa;
    function __construct($id, $nazwa)
    {
        $this->id = $id;
        $this->nazwa = $nazwa;
    }
}