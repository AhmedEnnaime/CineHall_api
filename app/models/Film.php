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
        try {
            $query = "SELECT f.*,h.name as hall FROM films f JOIN halls h ON f.hall_id = h.id WHERE f.date >= (SELECT CURRENT_DATE) ORDER BY f.date ASC;";
            $this->db->query($query);
            $result = $this->db->resultSet();
            return $result;
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    public function addFilm()
    {
        $films = $this->getFilms();
        try {
            $query = "INSERT INTO " . $this->table . " (date,time, hall_id,title) VALUES (:date,:time,:hall_id,:title)";
            $this->db->query($query);
            $this->db->bind(":date", $this->date);
            $this->db->bind(":time", $this->time);
            $this->db->bind(":hall_id", $this->hall_id);
            $this->db->bind(":title", $this->title);
            foreach ($films as $film) {
                if (strcmp($film->date, $this->date) == 0 && strcmp($film->time, $this->time) == 0 && $film->hall_id == $this->hall_id) {
                    return false;
                }
            }
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

    public function getFilmsCount()
    {
        return $this->getCount();
    }
}
