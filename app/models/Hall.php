<?php

class Hall extends Model
{

    protected $table = "halls";

    public $id;
    public $name;
    public $capacity;

    public function __construct()
    {
        parent::__construct();
    }

    public function getHalls()
    {
        return $this->getTable();
    }
}
