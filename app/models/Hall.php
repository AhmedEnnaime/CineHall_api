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

    public function getHallById($id)
    {
        return $this->getElementById($id);
    }

    public function createHall()
    {

        try {
            $query = "INSERT INTO " . $this->table . " (name,capacity) VALUES (:name,:capacity)";
            $this->db->query($query);
            $this->db->bind(":name", $this->name);
            $this->db->bind(":capacity", $this->capacity);
            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    public function deleteHall($id)
    {
        return $this->delete($id);
    }

    public function getHallsCount()
    {
        return $this->getCount();
    }

    public function updateHall($id)
    {
        try {
            $query = "UPDATE " . $this->table . " SET name=:name,capacity=:capacity WHERE id =:id";
            $this->db->query($query);
            $this->db->bind(":name", $this->name);
            $this->db->bind(":capacity", $this->capacity);
            $this->db->bind(":id", $id);
            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }
}
