<?php

class Film extends Model
{

    protected $table = "films";

    public $id;
    public $date;
    public $time;
    public $hall_id;
    public $title;

    public function __construct()
    {
        parent::__construct();
    }

    public function getFilms()
    {
        return $this->getTable();
    }

    public function addFilm()
    {

        try {
            $query = "INSERT INTO " . $this->table . " (date,time, hall_id,title) VALUES (:date,:time,:hall_id,:title)";
            $this->db->query($query);
            $this->db->bind(":date", $this->date);
            $this->db->bind(":time", $this->time);
            $this->db->bind(":hall_id", $this->hall_id);
            $this->db->bind(":title", $this->title);
            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    public function deleteFilm($id)
    {
        return $this->delete($id);
    }
}
