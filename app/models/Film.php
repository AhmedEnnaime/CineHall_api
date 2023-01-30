<?php

class Film extends Model
{

    protected $table = "films";

    public $id;
    public $date;
    public $time;
    public $hall_id;

    public function __construct()
    {
        parent::__construct();
    }

    public function getFilms()
    {
        return $this->getTable();
    }
}
